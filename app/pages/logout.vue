<template>
  <section class="logout">
    <div class="mwc">
      <button @click="logout()">Logout</button>
    </div>
  </section>
</template>

<script>
export default {
  methods: {
    logout() {
      // TODO: Fire request to server
      // Commit logout to store
      this.$store.commit('resetAuth');
      // Redirect to login page
      this.$router.replace('/login');
    }
  }
};
</script>
