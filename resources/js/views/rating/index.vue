
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header" />
            <div class="card-body">
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
                  <el-table-column label="Date" prop="date" align="center" />
                  <el-table-column label="Grade" prop="grade" align="center" />
                </el-table>

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
  name: 'RatingList',

  data() {
    return {
      avg: 0,
      subaverage: 0,
      tableData: [],
      subid: '',
      lessons: [],
      filterForm: {
        subject: 1,
      },
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
  },
  methods:
      {
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
          this.getTimeTable(this.subid);
        },
        getsubject() {
          axios
            .post('api/rating/subjects', { user_id: this.userid })
            .then(response => {
              this.lessons = response.data.data;
              this.subid = response.data.data[0].id;
              this.avg = response.data.average;
              this.getTimeTable();
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
