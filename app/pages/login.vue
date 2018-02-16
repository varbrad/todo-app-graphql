<template>
  <section class="login">
    <div class="mwc">
      <input type="text" v-model="username"/>
      <input type="password" v-model="password"/>
      <button @click="login()">Click to Login</button>
    </div>
  </section>
</template>

<script>
import { query } from '@/assets/api';

export default {
  middleware: ['non-auth'],
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    async login() {
      let r = await query(`
        mutation {
          viewer: authenticate(
            username:"${this.username}"
            password:"${this.password}"
          ) {
            id,
            username
          }
        }
      `);
      let viewer = r.data.viewer;
      if (viewer === null) return;
      this.$store.commit('authAttempt', viewer);
      // Redirect to index page
      this.$router.replace('/');
    }
  }
};
</script>
