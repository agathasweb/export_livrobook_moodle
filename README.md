Além dos arquivos é necessário criar as pastas temp e exporteds na raiz do projeto.

Lembre-se de executar chmod 777 em ambas as pastas para o PHP conseguir escrever nas pastas

Depois basta fazer upload do CSV no index.html e os arquivo exportados aparecerão na pasta exporteds

Compacte os arquivos HTML em um zip e faça upload dentro do livro moodle em importações de capitulos

//Caso queira remover as extensões .html dos títulos utilize a seguinte query

UPDATE mdl_book_chapters SET title = REPLACE(title, '.html', '') WHERE `id` > (IDs DOS NOVOS CAPITULOS QUE FORAM ADICIONADOS); 
