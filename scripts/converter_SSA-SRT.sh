#!/bin/bash

source="$1"
ssa_file="${source%.mkv}.ass"
srt_file="${source%.mkv}.srt"

process_file() {
    if [ -f "$srt_file" ]; then
        echo "O arquivo SRT já existe para $source, pulando a extração e conversão."
    else
        if [ -z "$subtitle_index" ]; then
            ffmpeg -i "$source" -vn -an -codec:s ass "$ssa_file"
            elif [ "$subtitle_index" -ne -1 ]; then
            ffmpeg -i "$source" -vn -an -map 0:s:"$subtitle_index" -codec:s ass "$ssa_file"
        fi
        
        if [ $? -ne 0 ]; then
            echo "Erro: Falha na extração da legenda para $source."
            return
        fi
        
        ffmpeg -i "$ssa_file" -c:s srt -metadata:s:s:0 language=por "$srt_file"
        
        if [ $? -ne 0 ]; then
            echo "Erro: Falha na conversão da legenda para $srt_file."
            return
        fi
        
        rm "$ssa_file"
        
        echo "Legenda extraída e convertida para $srt_file"
    fi
}

process_subtitle() {
    subtitle_index=-1
    ffmpeg -y -i "$1" -map 0:s:m:language:por -c:s ass "$ssa_file"
}

if [ $# -ne 1 ]; then
    echo "Uso: $0 <diretório ou arquivo>"
    exit 1
fi

if [ -d "$source" ]; then
    for file in "$source"/*.mkv; do
        if [ -f "$file" ]; then
            process_subtitle "$file"
            process_file "$file" "$subtitle_index"
        fi
    done
    elif [ -f "$source" ]; then
    process_file "$source" "$subtitle_index"
else
    echo "O arquivo ou diretório especificado não existe."
    exit 1
fi