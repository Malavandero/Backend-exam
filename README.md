# EXAMEN

**REQUISITOS PREVIOS:**

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

**5 - Setup Virtual Machine** - modifica la variable LOCAL_SRC_PATH del archivo *vagrant/Vagrantfile* (dentro del proyecto), y pon la URL absoluta hacia tu proyecto clonado en el paso anterior
```bash
LOCAL_SRC_PATH = "/Users/eduard/PhpstormProjects/exam"
```

**6 - Run Virtual Machine** - levanta la maquina virtual (la primera vez tarda más tiempo porque debe descargar la imagen y realizar la instalación)
```bash
$ cd vagrant
$ vagrant up
```

**7 - Verify** - comprueba que todo funcione correctramente
```bash
$ cd vagrant
$ vagrant ssh
$ symfony check:requirements
$ exit
visita http://192.168.12.100/
```

**EMPIEZA EL EXAMEN:**
