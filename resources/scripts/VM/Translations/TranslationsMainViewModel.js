import ko from 'knockout';
import csrf from '../../csrf';
import helpers from '../../helpers';

import LanguagesHandler from '../../Handlers/LanguagesHandler';
import TranslationsHandler from '../../Handlers/TranslationsHandler';

export default class TranslationsMainViewModel {
  constructor() {
    this.languages = ko.observableArray([]);
    this.currentLanguage = ko.observable(null);

    this.translations = ko.observableArray([]);
    this.filteredTranslations = ko.observableArray([]);

    this.translations.subscribe(() => {
      this.filterTranslations(this.currentLanguage());
    });

    this.newTranslationKey = ko.observable(null);
    this.addTranslationPopupOpen = ko.observable(false);

    this.alert = ko.observable({
      visible: ko.observable(false),
      text: ko.observable(),
      type: ko.observable()
    });
  }

  showAlert(type, message) {
    this.alert().visible(true);
    this.alert().type(type);
    this.alert().text(message);

    setTimeout(() => {
        this.alert().visible(false);
    }, 3000);
  }

  closeAlert = () => {
    this.alert().visible(false);
  }

  openAddTranslationPopup = () => {
    this.addTranslationPopupOpen(true);
  }

  closePopup = () => {
    this.addTranslationPopupOpen(false);
  }

  saveTranslations = () => {
    const data = {
      csrf_token: csrf.getToken(),
      translations: ko.toJS(this.translations)
    };

    return TranslationsHandler.updateTranslations(data).then(response => {
      csrf.updateToken(response.csrfToken);
      this.showAlert('success', 'Successfully saved!');
    })
  }

  filterTranslations = (language) => {
    const translations = this.translations().filter(translation => {
      return translation.language_id() === language.id;
    });
    this.filteredTranslations(translations);
  }

  setCurrentLanguage = (language) => {
    this.currentLanguage(language);
    this.filterTranslations(language);
  }

  fetchLanguages() {
    const data = {
      csrf_token: csrf.getToken(),
    };

    return LanguagesHandler.fetchLanguages(data).then((response) => {
      csrf.updateToken(response.csrfToken);
       response.languages.forEach(language => {
          this.languages.push(language);
       });
       this.currentLanguage(this.languages()[0]);
    });
  }

  fetchTranslations() {
    const data = {
      csrf_token: csrf.getToken(),
    };

    return TranslationsHandler.fetchTranslations(data).then(response => {
      csrf.updateToken(response.csrfToken);
      response.translations.forEach(translation => {
        const newTranslation = this.newTranslation(translation);
        
        this.translations.push(newTranslation);
      });
    })
  }

  createTranslation = () => {
    const data = {
      csrf_token: csrf.getToken(),
      translation: {
        key: helpers.createSlug(this.newTranslationKey())
      }
    };

    this.newTranslationKey(null);

    return TranslationsHandler.addTranslation(data).then(response => {
      csrf.updateToken(response.csrfToken);
      response.translations.forEach(translation => {
        const newTranslation = this.newTranslation(translation);
        this.translations.push(newTranslation);
        this.showAlert('success', 'Translation added!');
      });
    });
  }

  newTranslation = (data) => {
    const newTranslation = {};
    for(let key in data) {
      newTranslation[key] = ko.observable(data[key]);
    }
    return newTranslation;
  }
}