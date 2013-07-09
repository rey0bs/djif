#!/bin/bash

SCRIPT_DIR="${0%/*}"

. "${SCRIPT_DIR}/connexion"
. "${SCRIPT_DIR}/functions"

${DB_QUERY} <<EOF
ALTER TABLE djifs ADD title VARCHAR(200);
EOF

for AUDIO in $(${DB_QUERY} -Bse "SELECT DISTINCT audio FROM djifs WHERE title IS NULL")
do
	URL="$(${DB_QUERY} -Bse "SELECT url FROM media WHERE id = '${AUDIO}'")"
	#echo "${AUDIO} : ${URL}"
	FILENAME="$(echo ${URL} | sed -n 's|.*/\([^/]\+\).ogg|\1|p')"
	if [[ -z "${FILENAME}" ]]
	then
		FILENAME="$(echo ${URL} | sed -n 's|.*/\([^/]\+\).mp3|\1|p')"
	fi
	if [[ -n "${FILENAME}" ]]
	then
		TITLE="${FILENAME}"
	else
		YT_ID="${URL##*/}"
		if [ "${YT_ID##*v=}" == "${YT_ID}" ]
		then # ID part of the URL
			YT_ID="${YT_ID%\?*}"
		else # ID passed as get variable v
			YT_ID="${YT_ID##*v=}"
			YT_ID="${YT_ID%%&*}"
		fi
		TITLE="$(curl -s "http://gdata.youtube.com/feeds/api/videos/${YT_ID}?alt=json" | sed -n 's|.*"title":{"$t":"\([^"]\+\)".*|\1|p')"
	fi
	if [ -z "${TITLE}" ]
	then
		echo -e "\n###########\n# WARNING #\n###########\n\nCouldn't retrieve title for audio with id '${AUDIO}' - You **MUST** set it manually"
	else
		${DB_QUERY} -Bse "UPDATE djifs SET title = '${TITLE}' WHERE audio = '${AUDIO}'"
	fi
done
