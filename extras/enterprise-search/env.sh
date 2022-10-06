#####################################################
## Elastic Enterprise Search Environment Variables ##
#####################################################

# Java options for JVM tuning (used for app-server and CLI commands)
export JAVA_OPTS=${JAVA_OPTS:-"-Xms1400m -Xmx1400m"}

# Additional Java options for the application server
export APP_SERVER_JAVA_OPTS="${APP_SERVER_JAVA_OPTS:-}"

#------------------------------------------------------------------------------
# Enable Java GC logging (see below for the default configuration)
export JAVA_GC_LOGGING=true
#export JAVA_GC_LOGGING=false # by lhs

# Example Environment variables for further logging configuration:

# Where to put the files
# export JAVA_GC_LOG_DIR=log
#
# How many of the most recent files to keep
# export JAVA_GC_LOG_KEEP_FILES=10
#
# How big GC logs should grow before triggering log rotation
# export JAVA_GC_LOG_MAX_FILE_SIZE=10m
