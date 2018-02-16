export function query(body) {
  return fetch('api/', {
    body: JSON.stringify({
      query: body
    }),
    method: 'POST',
    credentials: 'include',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  }).then(r => r.json());
}
