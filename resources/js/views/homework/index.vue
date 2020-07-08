
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" />

            <div class="card-body">
              <div id="app">

                <el-tabs type="border-card" @tab-click="getHomeWork">
                  <el-tab-pane v-for="tab in lessons" :key="tab.id" :label="generateTitle(tab.name)">
                    <el-table :data="tableData" border fit highlight-current-row style="width: 100%">
                      <el-table-column align="center" :label="generateTitle('Date')" prop="date" />
                      <el-table-column :label="generateTitle('description')" prop="description" align="center" />
                      <!--                      <el-table-column class-name="status-col" label="Status">-->
                      <!--                        <template slot-scope="scope">-->
                      <!--                          <el-tag :type="scope.row.status | statusFilter">{{ scope.row.status }}</el-tag>-->
                      <!--                        </template>-->
                      <!--                      </el-table-column>-->
                      <el-table-column v-if="status == 0" align="center" :label="generateTitle('action')">
                        <template slot-scope="scope">
                          <router-link :to="'/homework/create/' + scope.row.id">
                            <el-button type="primary" size="small" icon="el-icon-edit">{{ generateTitle('addhomework') }}</el-button>
                          </router-link>
                        </template>
                      </el-table-column>
                      <el-table-column v-if="status == 1 && editid" align="center" label="Actions">
                        <template>
                          <router-link :to="'/homework/edit/'+editid">
                            <el-button type="success" size="small" icon="el-icon-view">
                              view
                            </el-button>
                          </router-link>
                        </template>
                      </el-table-column>
                      <el-table-column :label="generateTitle('grade')" prop="grade" align="center" />
                    </el-table>
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
import { generateTitle } from '@/utils/i18n';

// import local from './local';
// const viewName = 'i18nView';
export default {
  name: 'Homework',
  components: {
  },
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
      file: '',
      lessonName: '',
      tableData: [],
      subid: 1,
      lessons: [],
      homework_id: '',
      ff: '',
      status: 0,
      editid: '',
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
        generateTitle,
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
          // console.log(this.userid);
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
              this.status = response.data.status;
              this.editid = response.data.id;
              console.log(this.status);
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
