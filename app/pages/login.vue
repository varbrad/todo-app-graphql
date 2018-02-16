<template>
  <section class="login">
    <div class="mwc">
      <button @click="login()">Click to Login</button>
    </div>
  </section>
</template>

<script>
export default {
  middleware: ['non-auth'],
  methods: {
    login() {
      this.$store.commit('authAttempt', {
        id: -1,
        username: 'Test'
      });
      // Redirect to index page
      this.$router.replace('/');
    }
  }
};
</script>
