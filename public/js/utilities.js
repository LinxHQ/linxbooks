function sanitizeFileName(name)
{
	name = name.replace(/\'/g, '');
	name = name.replace(/\"/g, '');
	name = name.replace(/\\/g, '');
	return name;
}