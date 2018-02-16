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
nav {
  width: 100%;
  background: rgb(173, 8, 35);
  overflow: hidden;
  color: white;
  padding: 0.25rem;

  > .mwc {
    display: flex;
    align-items: center;
  }
}

.title {
  color: white;
  font-size: 0.8rem;
  font-weight: bold;
  margin: 0;
  padding: 0;
  margin-right: auto;
}

.username {
  font-size: 0.8rem;
  padding: 0 1rem;
  margin: 0;
}

.link {
  color: white;
  border: 2px solid white;
  font-size: 0.8rem;
  padding: 0.25rem 0.5rem;
  margin-left: 0.25rem;
  border-radius: 3px;
  text-decoration: none;
  font-weight: bold;

  &.alt {
    background-color: white;
    color: rgb(173, 8, 35);
  }
}
</style>
