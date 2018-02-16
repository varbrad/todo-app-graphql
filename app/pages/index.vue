<template>
  <section class="container">
    <div class="mwc">
      <aside class="lists">
        <h1>Your Lists</h1>
        <nuxt-link to="/" v-for="list in $store.state.viewer.lists" :key="list.id">Link</nuxt-link>
      </aside>
      <section class="content">

      </section>
    </div>
  </section>
</template>

<script>
export default {
  middleware: ['auth']
};
</script>

<style lang="scss" scoped>
@import '../assets/vars';

.mwc {
  display: flex;
  margin-top: 1rem;
  padding: 0 1rem;

  > .lists {
    border: 2px solid $primary;
    border-radius: 3px;
    min-width: 20vw;

    > h1 {
      padding: 0.5rem;
      margin: 0;
      background-color: rgba($primary, 0.05);
      text-align: center;
      color: $primary;
    }
  }

  > .content {
    flex: 1;
  }
}
</style>
