
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" />

            <div class="card-body">
              <div id="app">
                <el-tabs v-model="activeName">
                  <el-tab-pane label="სასწავლო სახელმძღვანელოები" name="first">
                    <el-row v-if="role.includes('admin') || role.includes('teacher')" style="margin-bottom:30px;">
                      <el-button type="primary" size="medium" icon="el-icon-plus" @click="bookVisible=true">
                        {{ generateTitle('Add') }}
                      </el-button>
                    </el-row>
                    <transition-group tag="main" name="card">
                      <article v-for="book in albums" :key="book.id" class="card">
                        <a :href="`api/books/${book.file}`" target="_blank">
                          <img v-if="book.cover !== ''" :src="`/upload/imgs/${book.cover}`" :alt="book.name" width="200px" height="300px">
                          <img v-else src="https://source.unsplash.com/random/300x300" :alt="book.name">
                          <div class="description">
                            <span class="playcount">
                              <span :style="{width: m_percentage(748) + '%'}" />
                            </span>
                            <h3 class="title" :data-mbid="book.description">{{ book.name }}</h3>
                            <p class="artist">{{ book.description }}</p> <br>
                            <el-button type="primary"> <a :href="`api/books/${book.file}`" target="_blank">{{ generateTitle('download') }}</a></el-button>
                          </div>
                        </a>
                      </article>
                    </transition-group>
                  </el-tab-pane>
                  <el-tab-pane label="დამატებითი ლიტერატურა" name="second">
                    <el-row v-if="role.includes('admin') || role.includes('teacher')" style="margin-bottom:30px;">
                      <el-button type="primary" size="medium" icon="el-icon-plus" @click="additionalVisible=true">
                        {{ generateTitle('Add') }}
                      </el-button>
                    </el-row>
                    <transition-group tag="main" name="card">
                      <article v-for="book in albums" :key="book.id" class="card">
                        <a :href="`api/books/${book.file}`" target="_blank">
                          <img v-if="book.cover !== ''" :src="`/upload/imgs/${book.cover}`" :alt="book.name" width="200px" height="300px">
                          <img v-else src="https://source.unsplash.com/random/300x300" :alt="book.name">
                          <div class="description">
                            <span class="playcount">
                              <span :style="{width: m_percentage(748) + '%'}" />
                            </span>
                            <h3 class="title" :data-mbid="book.description">{{ book.name }}</h3>
                            <p class="artist">{{ book.description }}</p> <br>
                            <el-button type="primary"> <a :href="`api/books/${book.file}`" target="_blank">{{ generateTitle('download') }}</a></el-button>
                          </div>
                        </a>
                      </article>
                    </transition-group>
                  </el-tab-pane>
                </el-tabs>

                <el-dialog
                  :title="generateTitle('AddNews')"
                  :visible.sync="bookVisible"
                  width="60%"
                >
                  <el-upload
                    list-type="picture-card"
                    action="api/news/upload"
                    :before-upload="handleImageSuccess"
                  >
                    <i slot="default" class="el-icon-plus" />
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios';
import { generateTitle } from '@/utils/i18n';

export default {
  name: 'Books',
  components: { },
  filters: {

  },
  data() {
    return {
      albums: [],
      activeName: 'first',
      file: '',
      lessonName: '',
      tableData: [],
      subid: 1,
      lessons: [],
      homework_id: '',
      ff: '',
      bookVisible: false,
      additionalVisible: false,
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

  },
  created() {
    this.getsubject();
  },
  methods:
      {
        generateTitle,
        m_percentage: function(value) {
          return parseInt((value * 100) / 1400);
        },
        getsubject() {
          console.log(this.userid);
          axios
            .post('api/books/get', { user_id: this.userid })
            .then(response => {
              this.albums = response.data.data;

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
      },

};
</script>

<style lang="scss" scoped>

  $card: #2B2A34;
  $spotify-green: rgb(30, 215, 96);
  $spotify-black: rgb(25, 20, 20);

  :root {
    --grid-gap: 50px;
    --grid-min: 195px;
    --grid-items: auto-fill;
  }

  a {
    color: inherit;
    text-decoration: none;
  }

  h1 {
    font-size: 25px;
    color: white;
  }

  h3 {
    font-size: 14px;
    margin-bottom: 5px;
  }

  h4 {
    font-size: 14px;
    margin-bottom: 10px;
    font-weight: 700;
  }

  p {
    margin-bottom: 16px;
    line-height: 1.5em;
  }

  code {
    display: block;
    font-family: monospace;
    font-size: 14px;
    color: $spotify-green;
    border-left: 2px solid rgba($spotify-black, 0.75);
    padding-left: 10px;
  span {
    color: white;
  }
  strong {
    background-color: $spotify-black;
    padding: 2px;
  }
  }

  // HEADER
     header {
       display: flex;
       align-items: center;
       padding: 20px 4%;
       margin-bottom: 20px;
       background: $spotify-black;
  @media screen and (max-width:768px) {
    flex-flow: column;
  }
  h1, p {
    width: 50%;
  @media screen and (max-width:768px) {
    width: 100%;
  }
  }
  p {
    text-align: right;
    color: rgba(white, 0.65);
  @media screen and (max-width:768px) {
    text-align: left !important;
    margin-top: 10px;
    text-indent: 63px;
  }
  }
  img {
    width: 48px;
    height: 48px;
    vertical-align: middle;
    margin-right: 10px;
  }
  }

  // GRID CONTROLS
     section#controls {
       margin: 8% 7%;
       display: flex;
  & > div {
      width: 50%;
      padding: 0 2%;
  input[type="range"] {
    width: 100%;
    margin-bottom: 30px;
  }
  label {
    background: $spotify-green;
    color: white;
    padding: 20px 40px;
    border-radius: 2px;
    float: right;
  }
  }
  h4 em {
    font-style: normal;
    font-weight: 400;
    color: rgba(white, 0.4);
  }
  p {
    color: rgba(white, 0.70);
  }
  }

  // GRID
     #app main {
       display: grid;
       grid-template-columns: repeat(var(--grid-items), minmax(var(--grid-min), 1fr));
       grid-gap: var(--grid-gap);
       counter-reset: rank;
       margin: 4%;

  article {
    counter-increment: rank;
    position: relative;
    box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    border-radius: 4px;
    overflow: hidden;
    animation: mouseOut 0.3s ease-in;
  .image {
    position: relative;
    width: 100%;
  &:after {
   // This forces the image container to be a square
   content: '';
     display: block;
     padding-bottom: 100%;
   }
  &:before {
     content: '•••';
     font-size: 24px;
     position: absolute;
     display: flex;
     width: 100%;
     height: 100%;
     align-items: center;
     justify-content: center;
     color: rgba(white, 0.1);
     z-index: 0;
   }
  img {
    position: absolute;
    top: 8px;
    left: 0;
    width: 90%;
    z-index: 10;
    opacity: 0;
  &.active {
     animation: imageFadeIn 0.5s ease-in forwards;
     animation-delay: 0.5s;
   }
  }
  }
  .description {
    padding-bottom: 10px;
  h3, p {
    padding: 0 10px;
  }
  p.artist {
    color: #666;
    text-transform: uppercase;
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 0;
  &:before {
     content: '';
     display: block;
     width: 25px;
     height: 2px;
     margin-bottom: 4px;
   }
  }
  }
  &:before {
     content: '#'counter(rank);
     display: block;
     width: 25px;
     height: 20px;
     line-height: 20px;
     color: white;
     position: absolute;
     z-index: 20;
     right: 0px;
     top: 0px;
     text-align: center;
     font-weight: 500;
     font-size: 12px;
   }
  .playcount {
    display: block;
    width: 100%;
    margin-bottom: 10px;
    font-size: 12px;
  span {
    position: relative;
    display: block;
    height: 2px;
    background: $spotify-green;
  }
  }
  }
  article:hover {
    animation: mouseOver 0.3s ease-in forwards;
  }
  }

  // ANIMATIONS
  @keyframes mouseOver {
    0% {
      top: 0;
    }
    100% {
      top: -5px;
    }
  }

  @keyframes mouseOut {
    0% {
      top: -5px;
    }
    100% {
      top: 0;
    }
  }

  @keyframes imageFadeIn {
    0% {
      opacity: 0;
    }
    50% {
      opacity: 0.1;
    }
    100% {
      opacity: 1;
    }
  }

  // VUE TRANSITIONS: CARD FADEIN
     .card-enter {
       opacity: 0;
     }

  .card-enter-to {
    opacity: 1;
  }

  .card-enter-active {
    transition: opacity 0.3s ease-in;
  }

</style>
