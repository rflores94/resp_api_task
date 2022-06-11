# resp_api_task

Información: para la bd, he utilizado sqlite, ya que se guarda en un ficher .db y es más rápido y cómodo para utilizar con Synfony.

Para levantar la API, debemos tener instalado symfony en nuestro sistema entrar dentro de la carpeta del proyecto y ejecutar: **symfony server:start**

Para probar la API, yo he utilizado Postman, que supongo que es lo que todos utilizamos :P

Los endpoints creados son los siguientes:
- 
- Create task: http://localhost:8000/api/task (POST) para añadir una nueva tarea. Le pasamos en el body como **x-xxx-form-urlencoded** los campos title (string) y donde (true/false).
- Get all tasks: http://localhost:8000/api/tasks (GET) para que nos devuelva el listado completo de tareas.
- Get task: http://localhost:8000/api/task/{id} (GET) para que nos devuelva la tarea con el id que le pasamos.
- Update task: http://localhost:8000/api/task/{id} (PUT) para actualizar la tarea con el id que le pasamos. Le pasamos en el body como **x-xxx-form-urlencoded** los campos title (string) y donde (true/false).
- Delete task: http://localhost:8000/api/task/{id} (Delete) para eliminar la tarea con el id que le pasamos.

