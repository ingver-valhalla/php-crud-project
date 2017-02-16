(function() {
  var menu = new Vue({
    el: '.menu',
    template: '#menu-tpl',

    data: {
      items: {
        index: { active: false, name: 'Главная страница' },
        parts: { active: false, name: 'Детали'},
        projects: { active: false, name: 'Проекты'},
        providers: { active: false, name: 'Поставщики'},
        cities: { active: false, name: 'Города'},
      }
    },
    methods: {
      getPage: function(pageName, push) {
        var items = this.items;
        var keys = Object.keys(items);
        var prevActive = null;

        for (var i = 0; i < keys.length; ++i) {
          if (items[keys[i]].active) {
            prevActive = keys[i];
            break;
          }
        }

        if (prevActive) {
          console.log(prevActive);
          if (prevActive === pageName) {
            return;
          } else {
            items[prevActive].active = false;
          }
        }
        Vue.http.get('api.php', { params: { page: pageName }})
          .then(response => {

            var res = response.body;
            //console.log('Response body:', res);

            app.page = pageName;
            app.messages = res.messages;
            app.content = null;
            if (res.fields && res.fields.length > 0 &&
                res.rows && res.rows.length > 0) {
              app.content = {
                fields: res.fields,
                rows: res.rows.map(function(row) {
                    return row.map(function(cell) {
                      return {
                        content: cell,
                        editable: false,
                        editedText: ''
                      };
                    });
                  })
              };
            }


            items[pageName].active = true;
            if (push) {
              window.history.pushState({ pageName: pageName }, '', pageName + '.php');
            }
          }, error => {
            console.error('Error:', error);
          });
      }
    },

    created: function() {
      var activePage = null;
      var items = document.querySelectorAll('.menu-item');

      for (var i = 0; i < items.length; ++i) {
        if (items[i].classList.contains('active')) {
          activePage = items[i].dataset.name;
          break;
        }
      }

      if (activePage) {
        this.getPage(activePage);
      }
    }
  });

  window.onpopstate = function(e) {
    console.log(e.state, e.url);
    if (e.state && e.state.pageName) {
      menu.getPage(e.state.pageName);
    } else {
      location.reload(true);
    }
  };
})();

