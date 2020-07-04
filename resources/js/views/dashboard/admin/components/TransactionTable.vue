<template>
  <el-table
    v-loading="loading"
    :data="list"
    style="width: 100%;"
  >
    <el-table-column :label="generateTitle('Subject')" style="max-height: 220px;">
      <template slot-scope="scope">
        {{ scope.row && scope.row.name | orderNoFilter }}
      </template>
    </el-table-column>
    <el-table-column :label="generateTitle('Average')" align="center">
      <template slot-scope="scope">
        <el-tag :type="scope.row.grade >5.5 ? 'success' : 'danger'">
          {{ scope.row.grade }}
        </el-tag>
      </template>
    </el-table-column>
    <el-table-column label="Attendance" align="center">
      <template slot-scope="scope">
        <el-tag :type="scope.row.attendance >60 ? 'success' : 'danger'">
          {{ scope.row && scope.row.attendance }}%
        </el-tag>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
// import { fetchList } from '@/api/order';
import axios from 'axios';
import { generateTitle } from '@/utils/i18n';

export default {
  filters: {
    statusFilter(status) {
      console.log(status);
      const statusMap = {
        success: 'success',
        pending: 'danger',
      };
      return statusMap[status];
    },
    orderNoFilter(str) {
      return str;
    },
  },
  data() {
    return {
      list: [{ order_no: '1', price: '2', status: 'pending' }],
      loading: true,
    };
  },
  computed: {
    userid() {
      return this.$store.getters.userId;
    },
  },
  created() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      // const { data } = await fetchList();
      // this.list = data.items.slice(0, 7);

      axios.post('api/rating/average', { user_id: this.userid })
        .then(response => {
          console.log(response.data);
          this.list = response.data.data;
        }).catch(error => {
          console.log(error);
        });

      this.loading = false;
    },
    generateTitle,
  },
};
</script>
