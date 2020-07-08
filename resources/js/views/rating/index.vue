
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" />
            <div v-if="role.includes('student')" class="card-body">
              <div class="col-md-12">
                <el-row>
                  <div class="col-md-4">
                    <el-form ref="filterForm" :inline="true" :model="filterForm">
                      <el-form-item prop="subject" label="">
                        <el-select v-model="filterForm.subject" name="status" @change="onSubmit">
                          <el-option
                            v-for="item in lessons"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id"
                          />
                        </el-select>
                      </el-form-item>
                    </el-form>
                  </div>
                  <div class="col-md-8" style="font-weight:600;font-size:16px;">
                    Average score: {{ avg }} <p v-if="avg < 5.5" style="color:red;"> თქვენ გჭირდებათ სულ მცირე 5.5 საშუალო ქულა, რომ გადახვიდეთ შემდეგ კლასში</p>
                    <p v-if="subaverage < 5.5" style="color:red;"> საგნის ჩასაბარებლად საჭიროა სულ მცირე 5.5 ქულა </p>
                  </div>
                </el-row>
                <el-table
                  :data="tableData"
                  style="width: 70%"
                  :header-cell-style="tableHeaderColor"
                  :row-class-name="tableRowClassName"
                  border
                  :summary-method="getSummaries"
                  show-summary
                >
                  <el-table-column :label="generateTitle('Date')" prop="date" align="center" />
                  <el-table-column :label="generateTitle('Grade')" prop="grade" align="center" />
                </el-table>
              </div>
            </div>

            <div v-if="role.includes('admin')" class="card-body">
              <el-tabs type="border-card" @tab-click="getRating">
                <el-tab-pane v-for="tab in classes" :key="tab.id" :label="generateTitle(tab.name)">
                  <div class="col-md-12">
                    <el-row>
                      <div class="col-md-4">
                        <el-form ref="filterForm" :inline="true" :model="filterForm">
                          <el-form-item prop="subject" label="">
                            <el-select v-model="filterForm.subject" name="status" @change="onSubmit">
                              <el-option
                                v-for="item in lessons"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                              />
                            </el-select>
                          </el-form-item>
                        </el-form>
                      </div>
                    </el-row>
                    <el-table
                      :data="tableData"
                      style="width: 70%"
                      :header-cell-style="tableHeaderColor"
                      :row-class-name="tableRowClassName"
                      border
                      :summary-method="getSummaries"
                      show-summary
                    >
                      <el-table-column :label="generateTitle('Date')" prop="date" align="center" />
                      <el-table-column :label="generateTitle('Name')" prop="name" align="center" />
                      <el-table-column :label="generateTitle('Email')" prop="email" align="center" />
                      <el-table-column :label="generateTitle('Grade')" prop="grade" align="center" />
                      <el-table-column :label="generateTitle('Action')" align="center">
                        <template slot-scope="scope">
                          <el-button type="primary" class="btn btn-primary" size="mini" icon="el-icon-edit" @click="remove(scope.row)" />
                          <el-button type="danger" class="btn btn-danger" size="mini" icon="el-icon-delete" @click="remove(scope.row)" />
                        </template>
                      </el-table-column>
                    </el-table>
                  </div>
                </el-tab-pane>
              </el-tabs>
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
  name: 'RatingList',

  data() {
    return {
      avg: 0,
      subaverage: 0,
      tableData: [],
      subid: '',
      lessons: [],
      classes: [],
      classid: '',
      filterForm: {
        subject: 1,
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
    // console.log('Component mounted.');
  },
  created() {
    if (this.role.includes('student') || this.role.includes('parent')) {
      this.getsubject();
    } else if (this.role.includes('teacher') || this.role.includes('admin')) {
      this.getClass();
    }
  },
  methods:
      {
        generateTitle,
        getTimeTable(subid = this.subid) {
          axios
            .post('api/rating/get', { user_id: this.userid, lesson_id: subid })
            .then(response => {
              this.tableData = Object.values(response.data.data);
              this.subaverage = response.data.average;
            }).catch(error => {
              console.log(error);
            });
        },
        onSubmit() {
          this.subid = this.filterForm.subject;
          if (this.role.includes('student') || this.role.includes('parent')) {
            this.getTimeTable(this.subid);
          } else if (this.role.includes('teacher') || this.role.includes('admin')) {
            this.getAllScores();
          }
        },
        getsubject() {
          axios.post('api/rating/subjects', { user_id: this.userid })
            .then(response => {
              console.log('get subject');
              this.lessons = response.data.data;
              this.subid = response.data.data[0].id;
              this.avg = response.data.average;
              this.getTimeTable();
            }).catch(error => {
              console.log(error);
            });
        },
        getClass() {
          console.log('get class');
          axios.post('api/rating/class')
            .then(response => {
              this.classes = response.data.data;
              this.classid = response.data.data[0].id;
              axios.post('api/rating/lessons', { class: this.classid })
                .then(response => {
                  console.log('get lessons');
                  this.lessons = response.data.data;
                  this.subid = response.data.data[0].id;
                  this.avg = response.data.average;
                  this.getAllScores();
                }).catch(error => {
                  console.log(error);
                });
            }).catch(error => {
              console.log(error);
            });
        },
        getRating(tab, event) {
          console.log('get rating');
          this.classid = this.classes[tab.index].id;
          axios.post('api/rating/lessons', { class: this.classid })
            .then(response => {
              this.lessons = response.data.data;
            }).catch(error => {
              console.log(error);
            });
        },
        getAllScores(subid = this.subid) {
          axios.post('api/rating/getAll', { lesson_id: subid })
            .then(response => {
              console.log(response.data);
              this.tableData = Object.values(response.data.data);
              this.subaverage = response.data.average;
            }).catch(error => {
              console.log(error);
            });
        },
        tableHeaderColor({ row, column, rowIndex, columnIndex }) {
          if (rowIndex === 0) {
            return 'background-color: #ebf1fb;color: #496fec;font-weight:600;font-size:16px;text-align:center';
          } else if (rowIndex === 1) {
            return 'background-color: #f7faff;font-size:14px;text-align:center';
          } else if (rowIndex === 2) {
            return 'background-color: #f7faff;font-size:14px;text-align:center';
          }
        },
        tableRowClassName({ row, rowIndex }) {
          if (row.grade <= 5) {
            return 'other-row';
          } else if (row.grade > 8) {
            return 'success-row';
          } else {
            return 'warning-row';
          }
        },

        getSummaries(param) {
          const { columns, data } = param;
          const sums = [];
          let count = 0;
          columns.forEach((column, index) => {
            if (index === 0) {
              sums[index] = 'Average';
              return;
            }
            const values = data.map(item => Number(item[column.property]));
            if (!values.every(value => isNaN(value))) {
              sums[index] = values.reduce((prev, curr) => {
                const value = Number(curr);
                if (!isNaN(value)) {
                  count++;
                  return (prev + curr);
                } else {
                  return prev;
                }
              }, 0) / count;
            } else {
              sums[index] = 'N/A';
            }
          });
          return sums;
        },
      },

};
</script>

<style scoped>
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
