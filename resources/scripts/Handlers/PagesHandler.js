const PagesHandler = {};

PagesHandler.loadPageItems = async function() {
    const url = `/pages`;
    const response = await fetch(url, {
        method: 'POST',
        credentials: 'include'
    });

    const data = await response.json();

    return data;
};

PagesHandler.fetchPage = async function(data) {
   const url = `/pages/${data.pageID}`;
   const response = await fetch(url, {
      body: JSON.stringify(data),
      headers: {
         'content-type': 'application/json'
     },
      method: 'POST',
      credentials: 'include'
   });

   return await response.json();
};

 PagesHandler.setInEditInActive = async function(data) {
    const url = `/pages/inedit/inactive`;
    const response = await fetch(url, {
       body: JSON.stringify(data),
       headers: {
          'content-type': 'application/json'
      },
       method: 'POST',
       credentials: 'include'
    });
 
    return await response.json();
 };

export default PagesHandler;