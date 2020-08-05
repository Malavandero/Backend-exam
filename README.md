![GitHub Logo](logo_ivoox.png)

#REQUISITOS PREVIOS:

**1 - Cliente Git** , descargar e instalar : https://git-scm.com/downloads
```bash
$ sudo apt install git
$ git config --global core.autocrlf false
$ git config --global core.eol lf
# Set text=auto in your .gitattributes for all files:
* text=auto
```

**2 - VirtualBox**, descargar e instalar : https://www.virtualbox.org/wiki/Downloads
```bash
$ sudo apt install virtualbox
```

**3 - Vagrant**, descargar e instalar : https://www.vagrantup.com/downloads.html
```bash
$ sudo apt install vagrant
$ vagrant plugin install vagrant-vbguest
```

**4 - Clone repository** - https://github.com/Malavandero/Backend-exam
```bash
$ git clone https://github.com/Malavandero/Backend-exam exam
$ cd exam
```

**5 - Setup Virtual Machine** - modifica la variable LOCAL_SRC_PATH del archivo *vagrant/Vagrantfile* linea 1 (dentro del proyecto clonado), y pon la ruta absoluta hacia tu proyecto clonado en el paso anterior
```bash
LOCAL_SRC_PATH = "/Users/eduard/PhpstormProjects/exam"
```

**6 - Run Virtual Machine** - levanta la maquina virtual (la primera vez tarda más tiempo porque debe descargar la imagen y realizar la instalación)
```bash
$ cd vagrant
$ vagrant up
```

**7 - Check** - comprueba que todo funcione correctramente
```bash
$ cd vagrant
$ vagrant ssh
$ symfony check:requirements
$ exit
visita http://192.168.12.100/
```

**8 - Cuenta en GitHub** - Neceitaras una cuenta en github para hacer el fork y posterior pull request a nuestro repositorio.

# EL EXAMEN

Actualmente este repositorio contiene un proyecto Symfony 5 vacío. La prueba consiste en hacer un pull request a este mismo repositorio, para conseguir desarrollar una pequeña API REST:

- Crear dos entidades: Empresa y Empleado con relación 1-N:
    - Empresa (1)
        - Nombre
    - Empleado (N)
        - Nombre
        - Fecha de contratación
        
- Persistir las entidades en MySQL en la base de datos `exam` ya instalada
    - Host: 127.0.0.1
    - User: exam
    - Pass: qwerty
    - Version: 5.7
    
- Crear los recursos o endpoints necesarios en la API para poder realizar las siguientes acciones:
    - Crear Empresas y empleados
    - Añadir un empleado a una empresa
    - Eliminar un empleado
    - Modificar un empleado
    
- *IMPORTANTE:* Un requisito de nuestra API és que a las empresas cuyo nombre empiezan por la letra A, sólo se podrán tener empleados cuyo nombre
 empiecen por la letra A.
- Una vez terminado haz un pull request y revisaremios tu examen.
 
Se valorarán los siguientes puntos "extra":
 - Configurar y usar el ORM Doctrine
 - Crear un test unitario.
 - Gestión de Excepciones.
 - Documentación de los endpoints de la API.
 - El uso de el componente symfony/serializer.
 - Crear un comando Symfony que permita añadir empleados a una empresa.
