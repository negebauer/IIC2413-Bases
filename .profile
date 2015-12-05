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
gcl () {
    if [ -z "$1" ];
        then
        echo "You must specify an url to clone from";
    else
        git clone "$1";
    fi
}
gcm () {
    if [ -z "$1" ];
        then
        echo "You must specify a message for the commit";
    else
        git commit -m "$1";
    fi
}
glcm () {
    if [ -z "$1" ];
        then
        echo "You must specify a message for the local commit, or a file and message";
    elif [ -z "$2" ];
        then
        gad;
        gcm "$1";
    else
        gad "$1";
        gcm "$2";
    fi
}
gfcm () {
    if [ -z "$1" ];
        then
        echo "You must specify a message for the full commit, or a file and message";
    elif [ -z "$2" ];
        then
        gad;
        gcm "$1";
        gps;
    else
        gad "$1";
        gcm "$2";
        gps;
    fi
}
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
gmg () {
    if [ -z "$1" ];
        then
        echo "You must specify a branch to merge from. Current branches are:";
        git branch;
    else
        export currentBranch='git symbolic-ref --short HEAD';
        echo "Performing merge from ($1) to ($currentBranch) as merge commit";
        git merge --no-ff "$1";
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
