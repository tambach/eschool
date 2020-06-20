
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              Calendar
            </div>

            <div class="card-body">
              <div class="col-md-12">
                <el-table max-height="800" :data="tableData" :header-cell-style="tableHeaderColor" style="width: 100%" :row-class-name="tableRowClassName">
                  <el-table-column label="Time" prop="time" />
                  <el-table-column label="Monday" prop="Monday" />
                  <el-table-column label="Tuesday" prop="Tuesday" />
                  <el-table-column label="Wednesday" prop="Wednesday" />
                  <el-table-column label="Thursday" prop="Thursday" />
                  <el-table-column label="Friday" prop="Friday" />
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
  name: 'ScheduleList',

  data() {
    return {
      courseList: null,
      weekDays: [],
      tableData: [],
      lessons: '',
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
    // this.getCourseList();
    this.getTimeTable();
  },
  methods:
      {
        getTimeTable() {
          axios
            .post('api/schedule/get', { user_id: this.userid })
            .then(response => {
              console.log(response.data);
              this.tableData = Object.values(response.data.data);
              console.log(this.tableData);
            }).catch(error => {
              console.log(error);
            });
        },
        load(tree, treeNode, resolve) {
          setTimeout(() => {
            resolve([
              {
                id: 31,
                Time: '2016-05-01',
                name: 'wangxiaohu',
              }, {
                id: 32,
                Time: '2016-05-01',
                name: 'wangxiaohu',
              },
            ]);
          }, 1000);
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
          if (rowIndex % 2 === 1) {
            return 'warning-row';
          } else {
            return 'success-row';
          }
        },
      },
};
</script>

<style scoped>
  .el-table .warning-row {
    background: #f7faff;
  }
  .el-table .success-row {
    background: #ebf1fb;
  }
</style>
