import { getViewer } from '@/assets/api';

export default async function ({ store, redirect }) {
  if (store.state.authAttempted) return;
  let viewer = await getViewer();
  store.commit('authAttempt', viewer);
}
