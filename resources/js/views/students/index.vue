<template>
  <div class="app-container">
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div v-if="role.includes('admin')" class="card-body">

              <el-form ref="filterForm" :inline="true" :model="filterForm">
                <el-row>
                  <div class="col-md-4">
                    <el-button type="success" class="btn btn-success" icon="el-icon-plus" @click="dialog = true">
                      {{ generateTitle('AddStudent') }}
                    </el-button>
                    <el-button type="primary" class="btn btn-primary" icon="el-icon-circle-check" @click="dialog = true">
                      {{ generateTitle('Restore') }}
                    </el-button>
                  </div>
                  <br>
                  <el-form-item prop="status" label="">
                    <el-select v-model="filterForm.status" name="status" @change="onSubmit">
                      <el-option label="Show All" value="1" selected />
                      <el-option label="Only Me" value="2" />
                    </el-select>
                  </el-form-item>
                  <el-form-item label="" prop="search">
                    <el-input v-model="filterForm.search" :placeholder="generateTitle('Search')" @change="onSubmit">
                      <el-button slot="append" icon="el-icon-search" @click="onSubmit" />
                    </el-input>
                  </el-form-item>
                </el-row>
              </el-form>

              <el-dialog
                title="Ajouter un étudiant"
                :visible.sync="dialog"
                width="60%"
              >
                <el-form ref="createUserForm" v-loading="loading" :model="createUserForm" status-icon :rules="rules" class="demo-ruleForm">
                  <el-form-item :label="generateTitle('Nom')" prop="name">
                    <el-input v-model="createUserForm.name" size="mini" clearable style="width: 50%" />
                  </el-form-item>
                  <el-form-item :label="generateTitle('Email')" prop="email">
                    <el-input v-model="createUserForm.email" size="mini" clearable style="width: 50%" />
                  </el-form-item>
                  <el-form-item prop="class" :label="generateTitle('Classe')">
                    <el-select v-model="createUserForm.class" name="status">
                      <el-option
                        v-for="item in classes"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      />
                    </el-select>
                  </el-form-item>
                  <el-form-item>
                    <el-button type="success" @click="submitCreateForm()">Save</el-button>
                  </el-form-item>
                </el-form>
              </el-dialog>

              <div class="col-md-12">
                <el-table v-loading="loading" max-height="800" :data="result" @sort-change="sortChange">
                  <el-table-column :label="generateTitle('Name')" prop="name" sortable="custom" :sort-orders="sort_orders" />
                  <el-table-column :label="generateTitle('Email')" prop="email" sortable="custom" :sort-orders="sort_orders" />
                  <el-table-column :label="generateTitle('Class')" prop="class_id" sortable="custom" :sort-orders="sort_orders" />
                  <el-table-column :label="generateTitle('Action')" align="center">
                    <template slot-scope="scope">
                      <el-button type="primary" class="btn btn-primary" size="mini" icon="el-icon-edit" @click="remove(scope.row)" />
                      <el-button type="danger" class="btn btn-danger" size="mini" icon="el-icon-delete" @click="remove(scope.row)" />
                    </template>
                  </el-table-column>
                </el-table>
                <div class="text-center">
                  <br>
                  <el-pagination
                    background
                    layout="prev, pager, next"
                    :total="pagination.total"
                    :current-page.sync="pagination.current_page"
                    :page-size="pagination.per_page"
                    @current-change="paginationCurrentChange"
                  />
                  <br>
                </div>
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
  name: 'List',
  data() {
    return {
      result: [],
      pagination: {},
      loading: false,
      id: 0,
      sort_orders: ['ascending', 'descending'],
      sort_field: '',
      sort_order: 'asc',
      filterForm: {
        search: '',
        status: '',
        startDate: '',
        endDate: '',
      },
      createUserForm: {
        name: '',
        email: '',
        class: '',
      },
      search: 0,
      date_from: 0,
      date_to: 0,
      status: 0,
      classes: [],
      dialog: false,
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
  mounted: function() {
    this.loading = true;
    this.getAll();
  },
  created() {
    this.getClass();
  },
  methods: {
    generateTitle,
    getClass() {
      axios.post('api/rating/class')
        .then(response => {
          console.log(response.data);
          this.classes = response.data.data;
        }).catch(error => {
          console.log(error);
        });
    },
    submitCreateForm() {
      this.loading = true;

      axios.post('api/student/create', this.createUserForm)
        .then(response => {
          console.log('news create');
          console.log(response.data);
          this.loading = false;
          this.dialog = false;
          this.$notify({
            title: 'Success',
            message: 'News user added successfully',
            type: 'success',
            duration: 2000,
          });
          this.getAll();
        }).catch(error => {
          console.log(error);
        });
    },
    getAll(page = 1, date_from = this.date_from, date_to = this.date_to, search = this.search, id = this.id, sort_field = this.sort_field, sort_order = this.sort_order) {
      axios.get('/api/students/getall?page=' + page + '&date_from=' + date_from + '&date_to=' + date_to + '&search=' + search + '&id=' + id + '&sort_field=' + sort_field + '&sort_order=' + sort_order)
        .then(res => {
          this.pagination =
              {
                'current_page': res.data.current_page,
                'per_page': parseInt(res.data.per_page),
                'total': res.data.total,
              };
          this.loading = false;
          this.result = res.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    paginationCurrentChange(val) {
      this.loading = true;
      this.getAll(val);
    },
    sortChange: function(column) {
      this.loading = true;
      this.sort_field = column.prop;
      this.sort_order = column.order;
      this.getAll();
    },
    onSubmit(){
      this.search = (this.filterForm.search !== '') ? this.filterForm.search : 0;
      this.date_from = (this.filterForm.startDate !== null) ? this.filterForm.startDate : 0;
      this.date_to = (this.filterForm.endDate !== null) ? this.filterForm.endDate : 0;
      if (this.filterForm.status === 2) {
        this.id = this.$store.getters.currentUser.id;
      } else {
        this.id = 0;
      }

      this.loading = true;
      this.getAll();
    },
  },

};
</script>

<style scoped>

</style>
