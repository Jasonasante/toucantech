import React, { useState, useEffect } from 'react';

function App() {
  const [schools, setSchools] = useState([]);
  const [selectedSchool, setSelectedSchool] = useState('all');
  const [users, setUsers] = useState([]);

    // Function to fetch users based on selected school


  useEffect(() => {
    // Fetch schools from the API
    fetch('http://localhost:8000/api', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ action: 'getSchools' }),
    })
      .then(response => response.json())
      .then(data => {
        console.log(data)
        setSchools(data);
      })

    // Fetch all users initially
    fetchUsers('all');
  }, []);

  const fetchUsers = (school) => {
    fetch('http://localhost:8000/api', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ action: 'getUsers', school }),
    })
      .then(response => response.json())
      .then(data => {
        setUsers(data);
      });
  };

  // Handle school selection change
  const handleSchoolChange = (event) => {
    setSelectedSchool(event.target.value);
    fetchUsers(event.target.value);
  };

  return (
    <div>
      <h1>Schools</h1>
      <label htmlFor="schools">Choose a School:</label>
      <select name="school" id="schools" value={selectedSchool} onChange={handleSchoolChange}>
        <option value="all">All</option>
        {schools.map(school => (
          <option key={school.id} value={school.id}>{school.name}</option>
        ))}
      </select>
      <button type="button">+</button>

      <h2>Users</h2>
      {users.map(user => (
        <div key={user.id}>
          <p>Name: {user.name}</p>
          <p>Email: {user.email}</p>
        </div>
      ))}
    </div>
  );
}

export default App;
