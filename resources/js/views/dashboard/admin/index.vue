<template>
  <div class="dashboard-editor-container">
    <!--    <github-corner style="position: absolute; top: 0px; border: 0; right: 0;" />-->
    <!--    <panel-group @handleSetLineChartData="handleSetLineChartData" />-->
    <!--    <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">-->
    <!--      <line-chart :chart-data="lineChartData" />-->
    <!--    </el-row>-->

    <!--    <el-row v-if="role.includes('teacher')" :gutter="32" style="margin-bottom:30px;">-->

    <!--    <vue-poll v-bind="options" style="width:60%" @addvote="addVote" />-->

    <el-row :gutter="32" style="margin-bottom:30px;">
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 12}" :xl="{span: 12}" style="padding-right:8px;margin-bottom:30px;">
        <todo-list />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 12}" :xl="{span: 12}">
        <transaction-table />
      </el-col>
    </el-row>

    <el-button type="success" class="btn btn-psuccess" icon="el-icon-plus" @click="dialog = true">
      Ajouter un événement
    </el-button>

    <el-dialog
      title="Ajouter un événement"
      :visible.sync="dialog"
      width="60%"
    >
      <el-form ref="createUserForm" v-loading="loading" :model="createUserForm" status-icon :rules="rules" class="demo-ruleForm">
        <el-form-item label="Nom" prop="title">
          <el-input v-model="createUserForm.title" size="mini" clearable style="width: 50%" />
        </el-form-item>
        <el-form-item prop="type" label="Type">
          <el-select v-model="createUserForm.type" name="status">
            <el-option
              v-for="item in types"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
        </el-form-item>
        <el-form-item prop="date" label="Date">
          <el-date-picker
            v-model="createUserForm.date"
            type="datetime"
          />
        </el-form-item>
        <el-form-item prop="class" label="Class">
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
          <el-button type="success" @click="submitCreateForm()">Submit</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

    <FullCalendar :options="calendarOptions" @event-selected="eventSelected" />

    <el-row :gutter="32">
      <el-col :xs="24" :sm="24" :lg="8">
        <div class="chart-wrapper">
          <raddar-chart />
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="8">
        <div class="chart-wrapper">
          <pie-chart />
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="8">
        <div class="chart-wrapper">
          <bar-chart />
        </div>
      </el-col>
    </el-row>

    <el-row :gutter="8">
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 12}" :xl="{span: 12}" style="padding-right:8px;margin-bottom:30px;">
        <transaction-table />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 12}" :md="{span: 12}" :lg="{span: 6}" :xl="{span: 6}" style="margin-bottom:30px;">
        <todo-list />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 12}" :md="{span: 12}" :lg="{span: 6}" :xl="{span: 6}" style="margin-bottom:30px;">
        <box-card />
      </el-col>
    </el-row>
  </div>
</template>

<script>
// import GithubCorner from '@/components/GithubCorner';
// import PanelGroup from './components/PanelGroup';
// import LineChart from './components/LineChart';
import RaddarChart from './components/RaddarChart';
import PieChart from './components/PieChart';
import BarChart from './components/BarChart';
import TransactionTable from './components/TransactionTable';
import TodoList from './components/TodoList';
import BoxCard from './components/BoxCard';
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios'; // for selectable
// import VuePoll from 'vue-poll';

const lineChartData = {
  newVisitis: {
    expectedData: [100, 120, 161, 134, 105, 160, 165],
    actualData: [120, 82, 91, 154, 162, 140, 145],
  },
  messages: {
    expectedData: [200, 192, 120, 144, 160, 130, 140],
    actualData: [180, 160, 151, 106, 145, 150, 130],
  },
  purchases: {
    expectedData: [80, 100, 121, 104, 105, 90, 100],
    actualData: [120, 90, 100, 138, 142, 130, 130],
  },
  shoppings: {
    expectedData: [130, 140, 141, 142, 145, 150, 160],
    actualData: [120, 82, 91, 154, 162, 140, 130],
  },
};

export default {
  name: 'DashboardAdmin',
  components: {
    // GithubCorner,
    // PanelGroup,
    // LineChart,
    RaddarChart,
    PieChart,
    BarChart,
    TransactionTable,
    TodoList,
    BoxCard,
    FullCalendar,
    // VuePoll,
  },
  data() {
    return {
      dialog: false,
      lineChartData: lineChartData.newVisitis,
      calendarOptions: {
        plugins: [interactionPlugin, dayGridPlugin],
        initialView: 'dayGridMonth',
        dateClick: this.handleDateClick,
        selectable: true,
        locale: 'fr',
        events: [
          { title: 'Quiz en mathématiques', date: '2020-06-01', color: 'orange', textColor: 'black' },
          { title: 'Quiz en littérature', date: '2020-06-02', color: 'orange', textColor: 'black' },
          { title: 'Examen en français', date: '2020-06-01', color: 'red', textColor: 'black' },
          { title: 'Examen de chimie', date: '2020-06-02', color: 'red', textColor: 'black' },
          { title: 'Olympiade en anglais', date: '2020-06-11', color: 'yellow', textColor: 'black' },
          { title: 'Excursion ', date: '2020-06-12', color: 'green', textColor: 'black' },
          { title: 'Quiz en mathématiques', date: '2020-06-15', color: 'orange', textColor: 'black' },
          { title: 'Quiz en littérature', date: '2020-06-16', color: 'orange', textColor: 'black' },
          { title: 'Examen en français', date: '2020-06-18', color: 'red', textColor: 'black' },
          { title: 'Examen de chimie', date: '2020-06-19', color: 'red', textColor: 'black' },
          { title: 'Olympiade en anglais', date: '2020-06-23 12:00:00', color: 'yellow', textColor: 'black' },
          { title: 'Excursion ', date: '2020-06-23 13:12:00', color: 'green', textColor: 'black' },
        ],
      },
      options: {
        question: 'What\'s your favourite <strong>JS</strong> framework?',
        answers: [
          { value: 1, text: 'Vue', votes: 53 },
          { value: 2, text: 'React', votes: 35 },
          { value: 3, text: 'Angular', votes: 30 },
          { value: 4, text: 'Other', votes: 10 },
        ],
      },

      loading: false,
      types: [
        { id: 'red', name: 'Examen' },
        { id: 'orange', name: 'Quiz' },
        { id: 'yellow', name: 'Olympiade' },
        { id: 'green', name: 'Excursion' },
      ],
      classes: [],
      createUserForm: {
        title: '',
        type: '',
        date: '',
        class: '',
      },
      rules: {
        titles: [
          { required: true, message: 'Required field', trigger: 'change' },
        ],
        dates: [
          { required: true, message: 'Required field', trigger: 'change' },
        ],
      },
    };
  },
  computed: {
    role() {
      return this.$store.getters.roles;
    },
  },
  mounted() {
    this.role = this.role[0];
    console.log(this.role);
  },
  created() {
    this.getClass();
  },
  methods: {
    submitCreateForm() {
      this.calendarOptions.events.push({ title: this.createUserForm.title, date: this.createUserForm.date, color: this.createUserForm.type, textColor: 'black' });
      this.dialog = false;
      this.$notify({
        title: 'Success',
        message: 'L\'événement a ajouté avec succès',
        type: 'success',
        duration: 2000,
      });
    },
    getClass() {
      axios.post('api/rating/class')
        .then(response => {
          console.log(response.data);
          this.classes = response.data.data;
          this.classes.unshift({ name: 'Toutes les classes' });
        }).catch(error => {
          console.log(error);
        });
    },
    addVote(obj){
      console.log('You voted ' + obj.value + '!');
    },
    handleSetLineChartData(type) {
      this.lineChartData = lineChartData[type];
    },
    handleDateClick: function(arg) {
      alert('date click! ' + arg.dateStr);
    },
    eventSelected(){
      console.log('eventSelected');
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
