<template>
  <el-card v-if="user.name">
    <div class="user-profile">
      <div class="user-avatar box-center">
        <pan-thumb image="/images/images.jpeg" src="/images/images.jpeg" :height="'100px'" :width="'100px'" :hoverable="false" />
      </div>
      <div class="box-center">
        <div class="user-name text-center">
          {{ user.name }}
        </div>
        <div class="user-role text-center text-muted">
          {{ getRole() }}
        </div>
      </div>
      <div class="box-social">
        <el-table :data="social" :show-header="false">
          <el-table-column prop="name" label="" />
          <el-table-column prop="value" label="" />
        </el-table>
      </div>
      <!--      <div class="user-follow">-->
      <!--        <el-button type="primary" style="width: 100%;">-->
      <!--          Follow-->
      <!--        </el-button>-->
      <!--      </div>-->
    </div>
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';

export default {
  components: { PanThumb },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '/images/images.jpeg',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      social: [
        {
          'name': 'Class',
          'value': 'VI',
        },
        {
          'name': 'Teacher',
          'value': 'teacher123',
        },
      ],
    };
  },
  methods: {
    getRole() {
      const roles = this.user.roles.map(value => this.$options.filters.uppercaseFirst(value));
      return roles.join(' | ');
    },
  },
};
</script>

<style lang="scss" scoped>
.user-profile {
  .user-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
  .user-follow {
    padding-top: 20px;
  }
}
</style>
