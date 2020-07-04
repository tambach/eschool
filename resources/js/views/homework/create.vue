<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container">
      <sticky :class-name="'sub-navbar '+postForm.status">
        <!--                <CommentDropdown v-model="postForm.comment_disabled"/>-->
        <!--                <PlatformDropdown v-model="postForm.platforms"/>-->
        <!--                <SourceUrlDropdown v-model="postForm.source_uri"/>-->
        <el-button
          v-loading="loading"
          style="margin-left: 10px;"
          type="success"
          @click="submitForm"
        >Submit</el-button>
        <el-button v-loading="loading" type="warning" @click="draftForm">Draft</el-button>
      </sticky>

      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item style="margin-bottom: 40px;" prop="title">
              <MDinput v-model="postForm.title" :maxlength="100" name="name" required>Title</MDinput>
            </el-form-item>

            <div class="postInfo-container">
              <el-row>
                <!--                <el-col :span="8">-->
                <!--                  <el-form-item label-width="80px" label="Author:" class="postInfo-container-item">-->
                <!--                    <el-select-->
                <!--                      v-model="postForm.author"-->
                <!--                      :remote-method="getRemoteUserList"-->
                <!--                      filterable-->
                <!--                      remote-->
                <!--                      placeholder="Search user"-->
                <!--                    >-->
                <!--                      <el-option-->
                <!--                        v-for="(item,index) in userListOptions"-->
                <!--                        :key="item+index"-->
                <!--                        :label="item"-->
                <!--                        :value="item"-->
                <!--                      />-->
                <!--                    </el-select>-->
                <!--                  </el-form-item>-->
                <!--                </el-col>-->

                <!--                <el-col :span="10">-->
                <!--                  <el-form-item-->
                <!--                    label-width="120px"-->
                <!--                    label="Published date:"-->
                <!--                    class="postInfo-container-item"-->
                <!--                  >-->
                <!--                    <el-date-picker-->
                <!--                      v-model="postForm.display_time"-->
                <!--                      type="datetime"-->
                <!--                      format="yyyy-MM-dd HH:mm:ss"-->
                <!--                      placeholder="Select date and time"-->
                <!--                    />-->
                <!--                  </el-form-item>-->
                <!--                </el-col>-->

                <el-col :span="6" />
              </el-row>
            </div>
          </el-col>
        </el-row>

        <el-form-item prop="text" style="margin-bottom: 30px;">
          <Tinymce ref="editor" v-model="postForm.text" :height="400" />
        </el-form-item>

        <el-form-item prop="image_uri" style="margin-bottom: 30px;">
          <Upload v-model="postForm.image_uri" />
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import Tinymce from '@/components/Tinymce';
import Upload from '@/components/Upload/homework';
import MDinput from '@/components/MDinput';
import Sticky from '@/components/Sticky'; // Sticky header
// import { validateURL } from '@/utils/validate';
import { fetchArticle } from '@/api/article';
import axios from 'axios';
// import { userSearch } from '@/api/remoteSearch';

const defaultForm = {
  status: 'draft',
  title: '',
  text: '',
  content_short: '',
  source_uri: '',
  image_uri: '',
  display_time: undefined,
  id: undefined,
  platforms: ['a-platform'],
  comment_disabled: false,
  importance: 0,
  hwid: '',
  userid: '',
};

export default {
  name: 'ArticleDetail',
  components: {
    Tinymce,
    MDinput,
    Upload,
    Sticky,
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    const validateRequire = (rule, value, callback) => {
      if (value === '') {
        this.$message({
          message: rule.field + ' is required',
          type: 'error',
        });
        callback(new Error(rule.field + ' is required'));
      } else {
        callback();
      }
    };
    return {
      postForm: Object.assign({}, defaultForm),
      loading: false,
      userListOptions: [],
      rules: {
        title: [{ validator: validateRequire }],
        // content: [{ validator: validateRequire }],
      },
      tempRoute: {},
    };
  },
  computed: {
    contentShortLength() {
      return this.postForm.content_short.length;
    },
    lang() {
      return this.$store.getters.language;
    },
    userid() {
      return this.$store.getters.userId;
    },
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.postForm.hwid = id;
  },
  methods: {
    fetchData(id) {
      fetchArticle(id)
        .then(response => {
          this.postForm = response.data;
          // Just for test
          this.postForm.title += `   Article Id:${this.postForm.id}`;
          this.postForm.content_short += `   Article Id:${this.postForm.id}`;

          // Set tagsview title
          this.setTagsViewTitle();
        })
        .catch(err => {
          console.log(err);
        });
    },
    setTagsViewTitle() {
      const title =
          this.lang === 'zh'
            ? '编辑文章'
            : this.lang === 'vi'
              ? 'Chỉnh sửa'
              : 'Edit Article'; // Should move to i18n
      const route = Object.assign({}, this.tempRoute, {
        title: `${title}-${this.postForm.id}`,
      });
      this.$store.dispatch('updateVisitedView', route);
    },
    submitForm() {
      this.postForm.userid = this.userid;
      console.log(this.postForm);
      this.$refs.postForm.validate(valid => {
        if (valid) {
          this.loading = true;
          axios.post('api/homework/post', this.postForm)
            .then(response => {
              console.log(response.data);
            }).catch(error => {
              console.log(error);
            });

          this.$notify({
            title: 'Success',
            message: 'Home work has been uploaded successfully',
            type: 'success',
            duration: 2000,
          });
          this.postForm.status = 'published';
          this.loading = false;
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    draftForm() {
      if (
        this.postForm.text.length === 0 ||
          this.postForm.title.length === 0
      ) {
        this.$message({
          message: 'Please enter required title and content',
          type: 'warning',
        });
        return;
      }
      this.$message({
        message: 'Successfully saved',
        type: 'success',
        showClose: true,
        duration: 1000,
      });
      this.postForm.status = 'draft';
    },
    getRemoteUserList(query) {
      // userSearch(query).then(response => {
      //   if (!response.data.items) {
      //     return;
      //   }
      //   this.userListOptions = response.data.items.map(v => v.name);
      // });
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  @import "~@/styles/mixin.scss";
  .createPost-container {
    position: relative;
    .createPost-main-container {
      padding: 0 45px 20px 50px;
      .postInfo-container {
        position: relative;
        @include clearfix;
        margin-bottom: 10px;
        .postInfo-container-item {
          float: left;
        }
      }
    }
    .word-counter {
      width: 40px;
      position: absolute;
      right: -10px;
      top: 0px;
    }
  }
</style>
<style>
  .createPost-container label.el-form-item__label {
    text-align: left;
  }
</style>
