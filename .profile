export PS1="_____________________________________________________________________________ \n| \u @ \h - \t \d - #\#\n|\w\n|$ "

alias ll='ls -FGlhp'

############################### Some git aliases  ######################################
alias gst='git status'
alias gpl='git pull'
alias gps='git push'
alias glg='git log'
alias gfc='git fetch'
gad () {
        if [ -z "$1" ];
                then
                git add -A;
        else
                git add "$1";
        fi
}
gcl () { git clone "$@" ; }
gcm () { git commit -m "$@" ; }
glcm () { gad ; gcm "$@" ; }
gfcm () { gad ; gcm "$@" ; gps ; }
gtg () {
        if [ -z "$1" -a -z "$2" ];
                then
                git tag;
        elif [ -z "$2" ];
                then
                git show "$1";
        else
                git tag -a "$1" -m "$2";
                git push origin "$1";
        fi
}

# ~/.profile: executed by the command interpreter for login shells.
# This file is not read by bash(1), if ~/.bash_profile or ~/.bash_login
# exists.
# see /usr/share/doc/bash/examples/startup-files for examples.
# the files are located in the bash-doc package.

# the default umask is set in /etc/profile; for setting the umask
# for ssh logins, install and configure the libpam-umask package.
#umask 022

# if running bash
if [ -n "$BASH_VERSION" ]; then
    # include .bashrc if it exists
    if [ -f "$HOME/.bashrc" ]; then
	. "$HOME/.bashrc"
    fi
fi

# set PATH so it includes user's private bin if it exists
if [ -d "$HOME/bin" ] ; then
    PATH="$HOME/bin:$PATH"
fi
