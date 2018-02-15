<template>
  <section class="container">
    <h1>Hello!</h1>
    <pre>{{ response }}</pre>
  </section>
</template>

<script>
export default {
  data() {
    return {
      response: null
    };
  },
  async mounted() {
    let r = await fetch('api/', {
      body: JSON.stringify({
        query: `
        {
          list(id: 2) {
            title
          }
        }`
      }),
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    }).then(r => r.json());
    this.response = r;
  }
};
</script>
