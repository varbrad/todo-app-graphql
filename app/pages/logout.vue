<template>
  <section class="logout">
    <div class="mwc">
      <button @click="logout()">Logout</button>
    </div>
  </section>
</template>

<script>
import { query } from '@/assets/api';

export default {
  methods: {
    async logout() {
      // TODO: Fire request to server
      let r = await query(`
        mutation {
          logout
        }
      `);
      // Commit logout to store
      this.$store.commit('resetAuth');
      // Redirect to login page
      this.$router.replace('/login');
    }
  }
};
</script>
