echo 'comaster1 backup started'
ROOT=$1/comaster1
mkdir $ROOT

# Backup web files
WEBPATH=$ROOT/web
mkdir $WEBPATH
rsync -a --info=progress2 . $WEBPATH --exclude .git

# Backup db
DBPATH=$ROOT/db
mkdir $DBPATH
mysqldump -u$2 -p$3 --databases co1db > $DBPATH/dump.sql 2> /dev/null
echo 'comaster1 backup finished'
