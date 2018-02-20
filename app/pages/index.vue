<template>
  <section class="container">
    <div class="mwc">
      <aside class="lists">
        <h1>Your Lists</h1>
        <a href="#" to="/" v-for="list in lists" :key="list.id" :class="{ active : (activeList && activeList.id === list.id) }" @click="setList(list.id)">{{ list.title }}</a>
      </aside>
      <section class="content">
        <template v-if="activeList">
          <h2>{{ activeList.title }}</h2>
          <p v-for="item in activeList.items" :key="item.id" :class="{ completed : item.completed }">
            {{ item.content }}
          </p>
        </template>
      </section>
    </div>
  </section>
</template>

<script>
import { query } from '@/assets/api';

export default {
  middleware: ['auth'],
  data() {
    return {
      lists: null,
      activeList: null
    };
  },
  methods: {
    async setList(id) {
      this.activeList = null;
      let response = await query(`
      {
        list(id:${id}) {
          id,
          title,
          items {
            id,
            content,
            completed
          }
        }
      }
      `);
      this.activeList = response.data.list;
    }
  },
  async asyncData() {
    let response = await query('{ viewer { lists { id, title } } }');
    return {
      lists: response.data.viewer.lists
    };
  }
};
</script>

<style lang="scss" scoped>
@import '../assets/vars';

.mwc {
  display: flex;
  margin-top: 1rem;
  padding: 0 1rem;
  align-items: flex-start;

  > .lists {
    border: 1px solid $primary;
    flex: 20;
    margin-right: 1rem;

    > h1 {
      padding: 0.5rem;
      margin: 0;
      background-color: rgba($primary, 0.05);
      text-align: center;
      color: $primary;
      border-bottom: 2px solid rgba($primary, 0.25);
    }

    > a {
      display: block;
      padding: 0.5rem;
      font-size: 0.9rem;
      margin: 0;
      text-align: left;
      color: $dark;
      text-decoration: none;
      border-left: 4px solid rgba($primary, 0.2);

      &.active {
        border-color: rgba($primary, 0.5);
        color: $primary;
      }

      &:hover {
        background-color: rgba($dark, 0.05);
      }
    }
  }

  > .content {
    flex: 80;
    border: 1px solid $primary;

    > h2 {
      padding: 1rem;
      margin: 0;
      color: rgba($primary, 0.75);
      border-bottom: 1px solid rgba($primary, 0.2);
    }

    > p {
      padding: 1rem;
      margin: 0;
      color: $dark;
      background-color: rgba($primary, 0.01);

      &.completed {
        color: rgba($dark, .4);
      }
    }
  }
}
</style>
