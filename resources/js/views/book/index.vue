
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" />

            <div class="card-body">
              <div id="app">
                <el-tabs v-model="activeName" @tab-click="getHomeWork">
                  <el-tab-pane label="სასწავლო სახელმძღვანელოები" name="first">
                    <a href="api/getusers/get">
                      Download
                    </a>
                  </el-tab-pane>
                  <el-tab-pane label="დამატებითი ლიტერატურა" name="second">

                  </el-tab-pane>
                </el-tabs>

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

export default {
  name: 'Books',
  components: { },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      activeName: 'first',
      file: '',
      lessonName: '',
      tableData: [],
      subid: 1,
      lessons: [],
      homework_id: '',
      ff: '',
    };
  },
  computed: {
    userid() {
      return this.$store.getters.userId;
    },
  },
  mounted() {
    // console.log('Component mounted.');
  },
  created() {
    this.getsubject();
    this.getTable();
  },
  methods:
      {
        beforeUpload(file) {
          const isLt1M = file.size / 1024 / 1024 < 1;
          if (isLt1M) {
            return true;
          }
          this.$message({
            message: 'Please do not upload files larger than 1m in size.',
            type: 'warning',
          });
          return false;
        },
        handleSuccess({ results, header }) {
        },
        submitUpload(e) {
          const reader = new FileReader();

          reader.onload = e => console.log(e.target.result);

          this.file = e.target.files[0];
          console.log(this.file);

          e.preventDefault();
          const config = {
            headers: { 'content-type': 'multipart/form-data' },
          };
          const formData = new FormData();
          formData.append('file', this.file);
          formData.append('user', this.userid);
          formData.append('homework', this.homework_id);
          //
          // this.file = this.$refs.upload.files[0];
          // const formData = new FormData();
          // formData.append('file', this.file);

          axios.post('api/homework/upload', formData, config)
            .then(response => {
              console.log(response.data);
            }).catch(error => {
              console.log(error);
            });
        },
        getsubject() {
          console.log(this.userid);
          axios
            .post('api/rating/subjects', { user_id: this.userid })
            .then(response => {
              this.lessons = response.data.data;
              this.subid = response.data.data[0].id;
            }).catch(error => {
              console.log(error);
            });
        },
        getHomeWork(tab, event) {
          this.subid = this.lessons[tab.index].id;
          this.getTable();
        },
        getTable(subid = this.subid) {
          axios.post('api/homework/get', { user_id: this.userid, lesson_id: this.subid })
            .then(response => {
              this.tableData = response.data.hw;
              this.homework_id = response.data.hw.id;
            }).catch(error => {
              console.log(error);
            });
        },

        getFiles() {
          axios
            .get('api/homework/files')
            .then(response => {
              console.log(response.data);
              this.ff = response.data;
            }).catch(error => {
              console.log(error);
            });

          // this.$http.post('api/homework/files')
          //   .then(function (data) {
          //     console.log(data)
          //   })
        },
      },

};
</script>

<style scoped>
  .excel-upload-input{
    display: none;
    z-index: -9999;
  }
  #inputfile {
    visibility: hidden;
  }
  .el-table .warning-row {
    background: #f6fd62;
  }

  .el-table .success-row {
    background: #33fd73;
  }

  .el-table .other-row {
    background: #f83332;
  }

</style>
