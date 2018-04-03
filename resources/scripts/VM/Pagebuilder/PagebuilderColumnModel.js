import ko from 'knockout';
import PagebuilderElementModel from './PagebuilderElementModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderColumnModel {
   constructor(data, delegates) {
      this.id = ko.observable(data.id || '');
      this.col = ko.observable(data.col);

      this.element = ko.observable(null);
      this.elementSelected = ko.observable(false);

      if (ko.toJS(this.id)) {
         this.fetchElement();
      } else if (data.element) {
         this.element(
            new PagebuilderElementModel({
               ...ko.toJS(data.element),
               id: ''
            })
         );
         this.elementSelected(true);
      }

      this.removeCol = delegates.removeCol;
   }

   async fetchElement() {
      const response = await PagebuilderHandler.fetchElement(this.id());

      if (response) {
        const paddingArr = response.padding.split(' ');
        const marginArr = response.margin.split(' ');  
        const paddingVM = {top: paddingArr[0], right: paddingArr[1], bottom: paddingArr[2], left: paddingArr[3]};
        const marginVM = {top: marginArr[0], right: marginArr[1], bottom: marginArr[2], left: marginArr[3]};
         this.element(new PagebuilderElementModel({...response, paddingVM, marginVM}));
         this.elementSelected(true);
      }
   }

   setElement = element => {
      if (!this.elementSelected()) {
         this.element(
            new PagebuilderElementModel({
               ...ko.toJS(element),
               id: ''
            })
         );
         this.elementSelected(true);
      }
   };

   deleteElement = () => {
      this.elementSelected(false);
      this.element(null);
   };
}
