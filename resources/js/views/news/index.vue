<template>
  <div class="app-container">
    <main class="wrapper">
      <section id="breweries" class="breweries">
        <ul class="no-bullets">
          <li v-for="article in articles" :key="article.id">
            <figure>
              <img :src="`/upload/imgs/${article.cover}`">
              <figcaption><h3>{{ article.title }}</h3></figcaption>
            </figure>
            <p>
              {{ article.description.substring(0,100)+"..." }}
            </p>
            <router-link :to="{ name: 'newsshow', params: { id: article.id }}">
              <el-button type="primary" size="small" >
                სრულად
              </el-button>
            </router-link>

          </li>
        </ul>
      </section>
    </main>

  </div>
</template>

<script>

import axios from 'axios';

export default {
  name: 'News',
  components: { },
  filters: {

  },
  data() {
    return {
      articles: [],
    };
  },
  computed: {
    userid() {
      return this.$store.getters.userId;
    },
  },
  mounted() {
    this.getArticles();
  },
  created() {

  },
  methods:
      {
        getArticles() {
          console.log(this.userid);
          axios.get('api/articles/get')
            .then(response => {
              this.articles = response.data.data;
              console.log(response.data.data);
            }).catch(error => {
              console.log(error);
            });
        },
      },

};
</script>

<style lang="scss" scoped>
  /* Typography imported from Google Fonts */
  @import url('https://fonts.googleapis.com/css?family=Playfair+Display|Source+Sans+Pro:200,400');

  h1, h2, h3, h4, h5, h6 {
    font-family: 'Playfair Display', serif;
  }

  p, a {
    font-family: 'Source Sans Pro', sans-serif;
  }

  /* Generic styles */
  html {
    scroll-behavior: smooth;
  }

  a {
    text-decoration: none;
    color: white;
    border-radius: .25rem;
    text-align: center;
    display: inline-block;
    transition: all .3s;
  }

  a:hover {
    opacity: .6;
  }

  /* Styles for the hero image */
  .hero {
    /* Photo by mnm.all on Unsplash */
    background: url('https://images.unsplash.com/photo-1518176258769-f227c798150e') center;
    background-size: cover;
    padding: 4rem 2rem;
    /* grid styles */
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    align-items: center;
  }

  .hero > * {
    color: white;
  }

  .hero > h1 {
    font-size: 4rem;
    padding-bottom: 1rem;
  }

  .hero > article > p {
    font-size: 1.5rem;
    font-weight: 200;
  }

  .hero > article > a {
    padding: 1rem;
    margin-top: .75rem;
  }

  /* breweries styles */
  .breweries {
    padding: 2rem;
  }

  .breweries > ul {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    grid-gap: 1rem;
  }

  .breweries > ul > li {
    border: 1px solid #E2E2E2;
    border-radius: .5rem;
  }

  .breweries > ul > li > figure {
    max-height: 220px;
    overflow: hidden;
    border-top-left-radius: .5rem;
    border-top-right-radius: .5rem;
    position: relative;
  }

  .breweries > ul > li > figure > img {
    width: 100%;
  }

  .breweries > ul > li > figure > figcaption {
    position: absolute;
    bottom: 0;
    background-color: rgba(0,0,0,.7);
    width: 100%;
  }

  .breweries > ul > li > figure > figcaption > h3 {
    color: white;
    padding: .75rem;
    font-size: 1.05rem;
  }

  .breweries > ul > li > p {
    font-size: 1rem;
    line-height: 1.5;
    padding: 1rem .75rem;
    color: #666666;
  }

  .breweries > ul > li > a {
    padding: .5rem 1rem;
    margin: .5rem;
  }
  /* footer */
  footer {
    background-color: #333;
    padding: .75rem;
    color: white;
    text-align: center;
    font-size: .75rem;
  }

  ul.no-bullets {
    list-style-type: none; /* Remove bullets */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margins */
  }
</style>

