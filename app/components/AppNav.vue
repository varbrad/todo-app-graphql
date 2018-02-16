<template>
  <nav>
    <div class="mwc">
      <p class="title">TodoQL</p>
      <template v-if="$store.state.viewer === null">
      <nuxt-link class="link" to="/login" exact>Login</nuxt-link>
      <nuxt-link class="link alt" to="/register" exact>Register</nuxt-link>
      </template>
      <template v-else>
        <p class="username">Logged in as <b>{{ $store.state.viewer.username }}</b></p>
        <nuxt-link class="link" to="/logout" exact>Logout</nuxt-link>
      </template>
    </div>
  </nav>
</template>

<style lang="scss" scoped>
@import '../assets/vars';

nav {
  width: 100%;
  background: $primary;
  overflow: hidden;
  color: $light;
  padding: 0.5rem;

  > .mwc {
    display: flex;
    align-items: center;
  }
}

.title {
  color: $light;
  font-size: 1rem;
  font-weight: 700;
  margin: 0;
  padding: 0.2rem 0.4rem;
  margin-right: auto;
  border-radius: 5px;
  color: $secondary;
}

.username {
  font-size: 0.8rem;
  padding: 0 1rem;
  margin: 0;
}

.link {
  color: $light;
  border: 2px solid $light;
  font-size: 0.8rem;
  padding: 0.25rem 0.5rem;
  margin-left: 0.5rem;
  border-radius: 3px;
  text-decoration: none;
  font-weight: bold;

  &.alt {
    background-color: $light;
    color: $primary;
  }
}
</style>
