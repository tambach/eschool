
<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
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
    role() {
      return this.$store.getters.roles;
    },
  },
  mounted() {
    // console.log('Component mounted.');
  },
  created() {
    // this.getCourseList();
    console.log('fck u');
    this.getTimeTable();
  },
  methods:
      {
        getTimeTable() {
          let url = 'api/schedule/get';
          if (this.role.includes('admin')) {
            url = 'api/schedule/teacher';
          }
          console.log(url);
          axios.post(url, { user_id: 2 })
            .then(response => {
              console.log(response.data);
              this.tableData = Object.values(response.data.data);
              console.log(this.tableData);
            }).catch(error => {
              console.log(error);
            });
        },

        tableHeaderColor({ row, column, rowIndex, columnIndex }) {
          if (rowIndex === 0) {
            return 'background-color: #ebf1fb;color: #496fec;font-weight:600;font-size:16px;';
          } else if (rowIndex === 1) {
            return 'background-color: #f7faff;font-size:14px;';
          } else if (rowIndex === 2) {
            return 'background-color: #f7faff;font-size:14px;';
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
