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
      row[index].editedText = row[index].content;
    },
    cancelEdit: function(row, index) {
      row[index].editedText = '';
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
        params: {
          page: app.page,
          id: row[0],
          fieldName: this.content.fields[index],
          newValue: row[index].editedText
        }
      }).then(function(response) {
        //row[index].content = row[index].editedText;
        //row[index].editedText = '';
        var res = response.body;
        console.log("Response body:", res);
        console.log(res.messages);
        if (res.messages) {
          app.messages = res.messages;
        }
      }, function(error) {
        console.error("Error:", error);
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

