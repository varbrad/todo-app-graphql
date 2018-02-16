export default function ({ store, redirect }) {
  if (store.state.viewer !== null) redirect(-1);
}
