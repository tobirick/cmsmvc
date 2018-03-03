import ko from 'knockout';
import PagebuilderElementModel from './PagebuilderElementModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderColumnModel {
   constructor(data) {
      this.col = ko.observable(data.col);

      this.element = ko.observable(null);
      this.elementSelected = ko.observable(false);

      if (data.element) {
         this.elementSelected(true);
         this.element(
            new PagebuilderElementModel({
               ...ko.toJS(data.element),
               id: ''
            })
         );
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
      this.element(null);
      this.elementSelected(false);
   };
}
