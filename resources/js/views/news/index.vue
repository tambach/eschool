<template>
  <div class="app-container">
    <main class="wrapper">
      <!--      <el-row v-if="role.includes('admin')" :gutter="32" style="margin-bottom:30px;">-->
      <!--        <el-button type="primary" size="small" icon="el-icon-plus">-->
      <!--          {{ generateTitle('AddNews') }}-->
      <!--        </el-button>-->
      <!--      </el-row>-->
      <section id="breweries" class="breweries">
        <el-row v-if="role.includes('admin') || role.includes('teacher')" :gutter="32" style="margin-bottom:30px;">
          <el-button type="primary" size="medium" icon="el-icon-plus" @click="dialogVisible=true">
            {{ generateTitle('AddNews') }}
          </el-button>
        </el-row>
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
              <el-button type="primary" size="small">
                სრულად
              </el-button>
            </router-link>

          </li>
        </ul>
      </section>
      <el-dialog
        :title="generateTitle('AddNews')"
        :visible.sync="dialogVisible"
        width="60%"
      >

        <el-upload
          list-type="picture-card"
          action="api/news/upload"
          :before-upload="handleImageSuccess"
        >
          <i slot="default" class="el-icon-plus" />
          <div slot="file" slot-scope="{file}">
            <img
              class="el-upload-list__item-thumbnail"
              :src="file.url"
              alt=""
            >
            <span class="el-upload-list__item-actions">
              <span
                class="el-upload-list__item-preview"
                @click="handlePictureCardPreview(file)"
              >
                <i class="el-icon-zoom-in" />
              </span>
              <span
                v-if="!disabled"
                class="el-upload-list__item-delete"
                @click="handleDownload(file)"
              >
                <i class="el-icon-download" />
              </span>
              <span
                v-if="!disabled"
                class="el-upload-list__item-delete"
                @click="handleRemove(file)"
              >
                <i class="el-icon-delete" />
              </span>
            </span>
          </div>
        </el-upload>

        <el-form ref="createUserForm" v-loading="loading" :model="createUserForm" status-icon :rules="rules" class="demo-ruleForm">
          <el-form-item label="Title" prop="title">
            <el-input v-model="createUserForm.title" size="mini" clearable />
          </el-form-item>
          <el-form-item label="Text" prop="text">
            <el-input v-model="createUserForm.text" size="mini" type="textarea" :rows="10" clearable />
          </el-form-item>
          <el-form-item>
            <el-button type="success" @click="submitCreateForm()">Submit</el-button>
          </el-form-item>
        </el-form>

      </el-dialog>
    </main>

  </div>
</template>

<script>

import axios from 'axios';
import { generateTitle } from '@/utils/i18n';

export default {
  name: 'News',
  components: {
    // Upload,
  },
  filters: {

  },
  data() {
    return {
      dialogImageUrl: '',
      dialogVisible: false,
      disabled: false,
      articles: [],
      formData: null,
      loading: false,
      createUserForm: {
        title: '',
        text: '',
        file: '',
      },
      rules: {
        title: [
          { required: true, message: 'Required field', trigger: 'change' },
        ],
        text: [
          { required: true, message: 'Required field', trigger: 'change' },
        ],
      },

    };
  },
  computed: {
    userid() {
      return this.$store.getters.userId;
    },
    role() {
      return this.$store.getters.roles;
    },
  },
  mounted() {
    this.getArticles();
  },
  created() {

  },
  methods:
      {
        handleRemove(file) {
          console.log(file);
        },
        handlePictureCardPreview(file) {
          this.dialogImageUrl = file.url;
          this.dialogVisible = true;
        },
        handleDownload(file) {
          console.log(file);
        },

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
        handleImageSuccess(file) {
          this.formData = new FormData();
          this.formData.append('file', file);
          this.formData.append('user_id', this.userid);
          // formData.append('title', 'title');
          // formData.append('text', 'text');
        },
        submitCreateForm() {
          this.loading = true;
          const config = {
            headers: { 'content-type': 'multipart/form-data' },
          };
          this.formData.append('title', this.createUserForm.title);
          this.formData.append('text', this.createUserForm.text);

          axios.post('api/news/create', this.formData, config)
            .then(response => {
              console.log('news create');
              console.log(response.data);
              this.loading = false;
              this.$notify({
                title: 'Success',
                message: 'News published successfully',
                type: 'success',
                duration: 2000,
              });
              this.dialogVisible = false;
              this.getArticles();
            }).catch(error => {
              console.log(error);
            });
        },
        generateTitle,
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

  .excel-upload-input{
    display: none;
    z-index: -9999;
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

