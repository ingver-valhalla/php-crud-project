var app = new Vue({
  el: '.content-block',
  template: '#content-tpl',
  data: {
    page: 'index',
    content: null,
    messages: []
  },
  methods: {
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
      row[index].editable = false;
    },
    endEdit: function(row, index) {
      row[index].editable = false;
      if (arguments.length < 2) {
        return;
      } else if (row[index].content === row[index].editedText) {
        return;
      }

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
      console.log('Removing row', rowIndex);
      if (arguments.length < 1) {
        return;
      }

      Vue.http.post('api.php', {
        type: 'delete',
        page: app.page,
        id: app.content.rows[rowIndex][0].content,
        field_name: '',
        new_value: ''
      }).then(function(response) {
        var res = response.body;

        console.log('Response body', res);

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

