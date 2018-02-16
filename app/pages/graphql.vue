<template>
  <section class="graphql">
    <div class="mwc">
      <h1>GraphQL</h1>
      <div class="flex">
        <textarea v-model="query"></textarea>
        <pre>{{ response }}</pre>
      </div>
      <button @click="submit()">Submit</button>
    </div>
  </section>
</template>

<script>
import { query } from '@/assets/api';

export default {
  data() {
    return {
      query: '',
      response: null
    };
  },
  methods: {
    async submit() {
      let r = await query(this.query);
      this.response = r;
    }
  }
};
</script>


<style lang="scss" scoped>
.mwc {
  padding: 0.5rem;
}

.flex {
  display: flex;
  align-items: stretch;
  height: 50vh;

  > textarea {
    flex-grow: 1;
    flex-shrink: 0;
    margin: 0.5rem;
    padding: 0.5rem;
  }

  > pre {
    flex-grow: 1;
    flex-shrink: 0;
    padding: 0.5rem;
    margin: 0.5rem;
    background: #efefef;
    border: 1px solid #cfcfcf;
  }
}
</style>
