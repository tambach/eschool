<template>
  <el-dropdown trigger="click" class="international" @command="handleSetLanguage">
    <div>
      <svg-icon class-name="international-icon" icon-class="language" />
    </div>
    <el-dropdown-menu slot="dropdown">
      <el-dropdown-item :disabled="language==='en'" command="en">
        English
      </el-dropdown-item>
      <el-dropdown-item :disabled="language==='fr'" command="fr">
        français
      </el-dropdown-item>
      <el-dropdown-item :disabled="language==='ka'" command="ka">
        ქართული
      </el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
import local from '@/views/i18n/local';
const viewName = 'i18nView';
export default {
  computed: {
    language() {
      return this.$store.getters.language;
    },
    lang: {
      get() {
        return this.$store.state.app.language;
      },
      set(lang) {
        this.$i18n.locale = lang;
        this.$store.dispatch('app/setLanguage', lang);
      },
    },
  },
  created() {
    if (!this.$i18n.getLocaleMessage('en')[viewName]) {
      this.$i18n.mergeLocaleMessage('en', local.en);
      this.$i18n.mergeLocaleMessage('ru', local.fr);
      this.$i18n.mergeLocaleMessage('zh', local.ka);
    }
    this.setOptions(); // set default select options
  },
  methods: {
    handleSetLanguage(lang) {
      this.$i18n.locale = lang;
      this.$store.dispatch('app/setLanguage', lang);
      this.$message({
        message: 'Switch Language Success',
        type: 'success',
      });
    },
  },
};
</script>

<style scoped>
.international-icon {
  font-size: 20px;
  cursor: pointer;
  vertical-align: -5px!important;
}
</style>

