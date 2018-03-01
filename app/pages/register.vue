<template>
  <section class="register">
    <div class="mwc">
      <div class="form" :class="{ waiting }">
        <h1>Register</h1>
        <input type="text" placeholder="Username" v-model="username"/>
        <input type="password" placeholder="Password" v-model="password"/>
        <button @click="register()">Register</button>
        <p v-if="error !== null">{{ error }}</p>
      </div>
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
      password: '',
      error: null,
      waiting: false
    };
  },
  methods: {
    async register() {
      this.waiting = true;
      if (this.username === '') {
        this.error = 'Empty username';
        this.waiting = false;
        return;
      }
      if (this.password === '') {
        this.error = 'Empty password';
        this.waiting = false;
        return;
      }
      this.error = null;
      let r = await query(`
        mutation {
          viewer: createUser(
            username:"${this.username}"
            password:"${this.password}"
          ) {
            id,
            username
          }
        }
      `);
      let viewer = r.data.viewer;
      if (viewer === null) {
        this.error = r.errors[0].message;
        this.waiting = false;
        return;
      }
      this.$store.commit('authAttempt', viewer);
      // Redirect to index page
      this.$router.replace('/');
    }
  }
};
</script>

<style lang="scss" scoped>
@import '../assets/vars';

.mwc {
  display: flex;
  align-items: center;
  justify-content: center;
}

.form {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  width: 400px;
  border: 2px solid $primary;
  padding: 1rem;
  border-radius: 5px;

  &.waiting {
    opacity: 0.5;
  }

  > h1 {
    padding: 1rem;
    margin: -1rem -1rem 1rem -1rem;
    background: $secondary;
    color: $primary;
    text-align: center;
  }

  > input[type='text'],
  > input[type='password'] {
    font-size: 1rem;
    border: 2px solid $primary;
    border-radius: 5px;
    margin-bottom: 0.5rem;
    padding: 1rem;
    outline: none;
  }

  > button {
    margin-top: 0.5rem;
    cursor: pointer;
    background: linear-gradient(lighten($primary, 9%), $primary);
    border: none;
    color: $light;
    padding: 1rem;
    border-radius: 5px;
    outline: none;
    border-bottom: 2px solid darken($primary, 25%);
    font-size: 1rem;
    font-weight: bold;
  }

  > p {
    background-color: rgba($primary, 0.2);
    padding: 1rem;
    margin: 1rem -1rem -1rem -1rem;
    font-size: 1rem;
    color: darken($primary, 20%);
    text-align: center;
  }
}
</style>
