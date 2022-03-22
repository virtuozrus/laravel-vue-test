const axios = require('axios');

export default {
    name: 'app',
    created(){
        let self = this;
        axios.get('/api/posts', {
            email: 'tehtroodon@ya.ru',
            text: this.comment
        })
            .then(function (response) {
                self.comments = response.data;
            })
            .catch(function (error) {
                console .log(error);
            });
    },
    data() {
        return {
            comment_text: 'test',
            comments: []
        }
    },
    methods: {
        send_comment() {
            axios.post('/api/posts/new', {
                email: 'tehtroodon@ya.ru',
                text: this.comment_text
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
