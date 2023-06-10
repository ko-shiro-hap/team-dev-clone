async function fetchData(path, sql) {
  if (!sql) {
    alert('Please enter an SQL query.');
    return;
  }

  const response = await fetch(path, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `sql=${encodeURIComponent(sql)}`
  });

  if (!response.ok) {
    const error = await response.json();
    alert(error.error);
    return;
  }

  return await response.json();
}
