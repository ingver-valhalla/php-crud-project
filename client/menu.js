var menu = new Vue({
  el: '.menu',
  template: '#menu-tpl',

  data: {
    items: {}
  },
  methods: {
    getPage: function(pageName, pushToHistory) {
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
        if (prevActive === pageName) {
          //return;
        } else {
          items[prevActive].active = false;
        }
      }

      getServerPage(pageName, function(res) {
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
            app.addedRow = [];
            for (var i = 0; i < res.fields.length - 1; ++i) {
              app.addedRow.push('');
            }
          }


          items[pageName].active = true;
          if (pushToHistory) {
            window.history.pushState({ pageName: pageName }, '', pageName + '.php');
          }
      }, function(err) {
        console.error('Error:', err);
      });
    }
  },

  created: function() {
    var activePage = null;
    var items = document.querySelectorAll('.menu-item');

    for (var i = 0; i < items.length; ++i) {
      var pageName = items[i].dataset.name;
      if (items[i].classList.contains('active')) {
        activePage = pageName;
      }

      Vue.set(this.items, pageName, {
        active: false,
        name: items[i].querySelector('a').innerHTML.trim()
      });
    }

    if (activePage) {
      this.getPage(activePage);
    }
  }
});

window.onpopstate = function(e) {
  //console.log(e.state, e.url);
  if (e.state && e.state.pageName) {
    menu.getPage(e.state.pageName);
  } else {
    location.reload(true);
  }
};
