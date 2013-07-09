#!/bin/bash

SCRIPT_DIR="${0%/*}"

. "${SCRIPT_DIR}/connexion"
. "${SCRIPT_DIR}/functions"

${DB_QUERY} <<EOF
UPDATE types SET name = 'youtube' WHERE id = 1;
UPDATE types SET name = 'ogg' WHERE id = 2;
INSERT INTO types VALUES (3, 'mp3');
EOF

for AUDIO in $(${DB_QUERY} -Bse "SELECT DISTINCT audio FROM djifs")
do
	URL="$(${DB_QUERY} -Bse "SELECT url FROM media WHERE id = '${AUDIO}'")"
	if [ -n "$(echo ${URL} | sed -n 's|https\?://[^/]*youtu\.\?be[\./].*|&|p')" ]
	then
		#echo "$URL is a youtube media"
		TYPE="1"
	else
		case "${URL##*.}" in
			ogg)
				#echo "$URL is an ogg file"
				TYPE="2"
				;;
			mp3)
				#echo "$URL is a mp3 file"
				TYPE="3"
				;;
			*)
				echo -e "\n###########\n# WARNING #\n###########\n\nThere's currently no entry in table 'types' to represent audio format '${URL##*.}'. You **MUST** handle this case manually (by first adding a new line in 'types'"
				;;
		esac
	fi
	${DB_QUERY} -Bse "UPDATE media SET type = '${TYPE}' WHERE id = '${AUDIO}'"
done
echo "Done !"
