Certainly! Below is a new template for your `README.md` file:

```markdown
# Events Server

Welcome to the Events Server repository. This backend server powers the Events application, providing essential endpoints to manage events and user data.

## Endpoints

### Get All Events (GET)

**Endpoint:** [https://alleventsmayur.000webhostapp.com/get-all-events.php](https://alleventsmayur.000webhostapp.com/get-all-events.php)

### Add Event (POST)

**Endpoint:** [https://alleventsmayur.000webhostapp.com/add-event.php](https://alleventsmayur.000webhostapp.com/add-event.php)

**Request:**
```json
{
    "event_name": "Sample Event",
    "start_time": "01/01/2023",
    "end_time": "05/01/2023",
    "location": "Sample Location",
    "description": "Description of the event.",
    "category": "Sample Category",
    "banner_image": "https://example.com/sample-image.jpg"
}
```

**Response:**
```json
{
    "status": "201",
    "message": "Event added successfully"
}
```

### Add User (POST)

**Endpoint:** [https://alleventsmayur.000webhostapp.com/new-user](https://alleventsmayur.000webhostapp.com/new-user)

**Request:**
```json
{
    "name": "John Doe",
    "email": "john.doe@example.com"
}
```

**Response:**
```json
{
    "status": "201",
    "message": "User added successfully"
}
```

## Contact Information

- **Email:** [mpmayur2251998@gmail.com](mailto:mpmayur2251998@gmail.com)
- **GitHub:** [MayurCode2](https://github.com/MayurCode2)

Feel free to reach out for any questions or concerns related to this project.

## Deployment Information

- **Get All Events Endpoint:** [https://alleventsmayur.000webhostapp.com/get-all-events.php](https://alleventsmayur.000webhostapp.com/get-all-events.php)
- **Add Event Endpoint:** [https://alleventsmayur.000webhostapp.com/add-event.php](https://alleventsmayur.000webhostapp.com/add-event.php)
- **Add User Endpoint:** [https://alleventsmayur.000webhostapp.com/new-user](https://alleventsmayur.000webhostapp.com/new-user)
```

You can copy and paste this content into your `README.md` file. Feel free to customize it further based on your project's specific details and requirements.
