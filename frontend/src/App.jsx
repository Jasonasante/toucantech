import React, { useState, useEffect } from 'react';
import Form from './components/Form/Form';
import Attendees from './components/Attendees/Attendees';

function App() {
  const [schools, setSchools] = useState([]);
  const [selectedSchool, setSelectedSchool] = useState('all');
  const [members, setMembers] = useState([]);
  const [visible, setVisible] = useState(false)

  // fetch all data currently in schools and members table
  useEffect(() => {
    fetch('http://localhost:8000/')
      .then(response => response.json())
      .then(data => {
        setSchools(data.schools);
        setMembers(data.members);
      })

  }, []);

  //fetch all members from currently selected school
  const fetchUsers = (school) => {
    fetch('http://localhost:8000/api', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ school }),
    })
      .then(response => response.json())
      .then(data => {
        setMembers(data);
      });
  };

  // Handle school selection change
  const handleSchoolChange = (event) => {
    setSelectedSchool(event.target.value);
    fetchUsers(event.target.value);
  };

  // Handle opening and closing of add member form
  const openForm = () => setVisible((prev) => !prev);

  return (
    <>
      <div className='header'>
        <h1>Schools</h1>
        <div className="container">
        <label htmlFor="schools">Choose a School:</label>
          <select name="school" id="schools" value={selectedSchool} onChange={handleSchoolChange}>
            <option value="all">All</option>
            {schools.map(school => (
              <option key={school.id} value={school.id}>{school.name}</option>
            ))}
          </select>
          <button type="button" onClick={openForm}>+</button>
        </div>
      </div>
      <div className='info-display'>

        <Attendees members={members} currentView={selectedSchool} schools={schools} />

        <>
          {visible &&
            <Form schools={schools} setVisible={setVisible} refreshList={fetchUsers} currentView={selectedSchool} />
          }
        </>
      </div>
    </>
  );
}

export default App;
