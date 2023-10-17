import React, { useState } from 'react'
import './Form.css'

// Component to render add member form
const Form = ({ schools, setVisible, refreshList, currentView }) => {
    const [msg, setMsg] = useState('')

    // function to close the form
    const closeForm = () => {
        setVisible((prev) => !prev)
    };
    // function to handle form submission
    const handleForm = (evt) => {
        evt.preventDefault()

        const inputs = Array.from(document.getElementsByClassName("form-input"))
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        // regular expression pattern for first and last names
        const pattern = /^[A-Za-z]+(((\'|\-|\.)?([A-Za-z])+))?$/;
        const isFirstNameValid = pattern.test(firstName);
        const isLastNameValid = pattern.test(lastName);

        // validate first and last name
        if (!isFirstNameValid) {
            setMsg("Invalid Name");
            return;
        }

        if (!isLastNameValid) {
            setMsg("Invalid Name");
            return;
        }

        // check if at least one radio button is checked
        const radioButtons = document.getElementsByClassName("school-option");
        const isRadioButtonChecked = Array.from(radioButtons).some(button => button.checked);
        if (!isRadioButtonChecked) {
            setMsg("Please select a school.");
            return;
        }

        const data = new FormData(evt.target);
        data.set('name', `${firstName} ${lastName}`);

        // send form data to server
        fetch("http://localhost:8000/form", {
            method: "POST",
            body: data,
        })
            .then(response => response.json())
            .then(response => {
                if (response.hasOwnProperty("error")) {
                    console.log("Error occurred:", response.error);
                    inputs.forEach(input => {
                        input.classList.add("invalid")
                    })
                    setMsg(response["error"])
                    setTimeout(() => {
                        inputs.forEach(input => {
                            input.disabled = false
                            input.classList.remove("invalid")
                        })
                        setMsg('')
                    }, 2000);
                } else {
                    console.log(response["success"]);
                    setMsg(response["success"])
                    refreshList(currentView)
                    inputs.forEach(input => input.value = null)
                    setTimeout(() => {
                        inputs.forEach(input => {
                            input.disabled = false
                            if (input.type == "radio") {
                                input.checked = false
                            }
                        })
                    }, 2000);
                }
            })
    }

    return (

        <form onSubmit={handleForm} className="form-display">
            <div className="form-header">
                <h1>Add Member</h1>
                <button className="close-button" type="button" onClick={closeForm}>
                    <span>&times;</span>
                </button>
            </div>
            {msg &&
                <p className='message'>{msg}</p>
            }
            <div className='form-input-container'>
                <label htmlFor="first-name">First Name:</label>
                <input type="text" className='form-input' name="first-name" id="first-name" placeholder='First Name' pattern="/^[A-Za-z]+(((\'|\-|\.)?([A-Za-z])+))?$/" required />
            </div>
            <div className='form-input-container'>
                <label htmlFor="last-name">Last Name:</label>
                <input type="text" className='form-input' name="last-name" id="last-name" placeholder='Last Name' pattern="/^[A-Za-z]+(((\'|\-|\.)?([A-Za-z])+))?$/" required />
            </div>

            <div className='form-input-container'>
                <label htmlFor="email">Email:</label>
                <input type="email" className='form-input' name="email" id="email" placeholder='email@example.com' required />
            </div>
                <p className='select-school'>Select School</p>
            <div className='form-options'>
                {schools.map(school => (
                    <div className='school-options'>
                        <label key={"label " + school.id} htmlFor={school.id}>{school.name}</label>
                        <input type='radio' className='form-input school-option' key={"input " + school.id} value={school.id} name='school' id={school.id} />
                    </div>
                ))}
            </div>
            <button type="submit" className='form-submit'>Submit</button>
        </form>
    )
}

export default Form
