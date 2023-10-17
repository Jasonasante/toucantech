import React from 'react';
import './Attendees.css'

// Component to render the display of members of the currently selected school in a table
const Attendees = ({ members, currentView, schools }) => {
  return (
    <div className='attendees-display'>
      <h2>Members</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            {currentView === 'all' && <th>School</th>}
          </tr>
        </thead>
        <tbody>
          {members.map(member => (
            <tr key={member.id}>
              <td>{member.name}</td>
              <td>{member.email}</td>
              {currentView === 'all' && <td>{schools[member.school_id - 1].name}</td>}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default Attendees;
