var app = new Vue({
  el: '.content-block',
  template: '#content-tpl',

  data: {
    page: 'index',
    content: null,
    messages: [],
    addingRow: false,
    addedRow: []
  },

  methods: {
    addRow: function() {
      if (this.content) {
        this.addingRow = true;
      }
    },

    cancelAddRow: function() {
      this.addingRow = false;
    },

    endAddRow: function() {
      //console.log(this.addedRow);
      this.addingRow = false;

      Vue.http.post('api.php', {
        type: 'insert',
        page: app.page,
        values: app.addedRow,
        fields: app.content.fields.slice(1, Infinity)
      }).then(function(response) {
        var res = response.body;
        //console.log("Response body:", res);

        if (res.messages) {
          app.messages = res.messages;
        }

        if (res.success) {

          getServerPage(app.page, function(res) {
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
          }, function(err) {
            console.error('Error:', err);
          });

        } else {
          console.error('Request denied');
        }
      }, function(error) {
        console.error(error);
      });
    },

    edit: function(row, index) {
      if (arguments.length < 2 || index === 0) {
        return;
      }
      row[index].editable = true;
      if (row[index].editedText === '') {
        row[index].editedText = row[index].content;
      }
    },

    cancelEdit: function(row, index) {
      if (arguments < 2) {
        return;
      }
      row[index].editable = false;
    },

    endEdit: function(row, index) {
      if (arguments.length < 2) {
        return;
      } else if (row[index].content === row[index].editedText) {
        return;
      }
      row[index].editable = false;

      Vue.http.post('api.php', {
          type: 'update',
          page: app.page,
          id: row[0].content,
          field_name: this.content.fields[index],
          new_value: row[index].editedText
      }).then(function(response) {
        var res = response.body;
        //console.log("Response body:", res);

        if (res.messages) {
          app.messages = res.messages;
        }
        if (res.success) {
          row[index].content = res.changed_value;
          row[index].editedText = '';
        } else {
          console.error('Request denied');
        }
      }, function(error) {
        console.error("Error:", error);
      });
    },

    remove: function(rowIndex) {
      if (arguments.length < 1) {
        return;
      }

      Vue.http.post('api.php', {
        type: 'delete',
        page: app.page,
        id: app.content.rows[rowIndex][0].content,
      }).then(function(response) {
        var res = response.body;

        //console.log('Response body', res);

        if (res.messages) {
          app.messages = res.messages;
        }
        if (res.success) {
          app.content.rows.splice(rowIndex, 1);
        }
      }, function(error) {
        console.error('Request error');
      });
    }
  },

  directives: {
    autofocus: {
      inserted(el) {
        el.focus();
      }
    }
  }
});

function getServerPage(pageName, success, fail) {
  Vue.http.get('api.php', { params: { page: pageName }})
    .then(response => success(response.body), fail);
}
