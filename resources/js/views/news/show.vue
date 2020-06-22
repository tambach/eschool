<template>
  <div class="app-container">
    <div>
      <img :src="`/upload/imgs/${articles.cover}`">
      <figcaption><h3>{{ articles.title }}</h3></figcaption>
      <div>
        <p>
          {{ articles.description }}
        </p>
      </div>
      <div>
        <p>
          {{ articles.created_at }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios';

export default {
  name: 'ShowArticle',
  data() {
    return {
      articles: null,
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    console.log(id);
    axios.post('api/articles/byid', { id: id })
      .then(response => {
        this.articles = response.data.data;
        var date = new Date(this.articles.created_at);
        this.articles.created_at = (date.getMonth() + 1) + '-' + date.getDate() + '-' + date.getFullYear();
      }).catch(error => {
        console.log(error);
      });
  },
  methods: {

  },
};
</script>
