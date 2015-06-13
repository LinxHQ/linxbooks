<?php
/**
 * The EYiiPdfException exception class.
 * @author Borales <bordun.alexandr@gmail.com>
 * @link https://github.com/Borales/yii-pdf
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @package application.extensions.yii-pdf.EYiiPdf
 * @version 0.4.0
 */
class EYiiPdf extends CApplicationComponent
{
	/**
	 * Send the PDF document in browser with a specific name. The plug-in is used if available.
	 * The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
	 * @var string
	 */
	const OUTPUT_TO_BROWSER = "I";

	/**
	 * Forcing the download of PDF via web browser, with a specific name
	 * @var string
	 */
	const OUTPUT_TO_DOWNLOAD = "D";

	/**
	 * Write the contents of a PDF file on the server
	 * @var string
	 */
	const OUTPUT_TO_FILE = "F";

	/**
	 * Retrieve the contents of the PDF and then do whatever you want
	 * @var string
	 */
	const OUTPUT_TO_STRING = "S";

	/**
	 * @var array Key-value pairs parameters
	 */
	public $params = array();

	/**
	 * @var mpdf|null
	 */
	protected $_mpdf = null;

	/**
	 * @var HTML2PDF|null
	 */
	protected $_HTML2PDF = null;

	protected $_importedPaths = array();

	/**
	 * @param string $library_name
	 * @param array $constructorClassArgs
	 * @throws EYiiPdfException
	 */
	protected function initLibrary($library_name, $constructorClassArgs = array())
	{
		if (!isset($this->params[$library_name]) || !isset($this->params[$library_name]['librarySourcePath']))
			throw new EYiiPdfException(Yii::t('yii-pdf', 'You must set parameters first'), 500);

		# Fix for HTML2PDF - class filename is "html2pdf.class.php"
		if (isset($this->params[$library_name]['classFile']) && !isset(Yii::$classMap[$library_name]))
			Yii::$classMap[$library_name] = Yii::getPathOfAlias($this->params[$library_name]['librarySourcePath']) . DIRECTORY_SEPARATOR . $this->params[$library_name]['classFile'];

		# Reserve required constants
		$this->initConstants($library_name);

		$sourcePath = $this->params[$library_name]['librarySourcePath'];
		if (!array_key_exists($sourcePath, $this->_importedPaths))
			$this->_importedPaths[$sourcePath] = Yii::import($sourcePath, true);

		# Merging params arrays (preserving params' indexes)
		$args = isset($this->params[$library_name]['defaultParams'])
			? $constructorClassArgs + array_values($this->params[$library_name]['defaultParams'])
			: $constructorClassArgs;

		$reflectionClass = isset($this->params[$library_name]['class']) ? $this->params[$library_name]['class'] : $library_name;

		$r = new ReflectionClass($reflectionClass);
		$this->{"_" . $library_name} = $r->newInstanceArgs($args);
	}

	/**
	 * Registering required constants
	 * @param string $library_name
	 */
	protected function initConstants($library_name)
	{
		if (!isset($this->params[$library_name]['constants']))
			return;

		foreach ((array)$this->params[$library_name]['constants'] as $constant_name => $constant_value)
			defined($constant_name) or define($constant_name, $constant_value);
	}

	/**
	 * @return mpdf
	 */
	public function mpdf()
	{
		$args=func_get_args();
		$this->initLibrary(__FUNCTION__, $args);
		return $this->_mpdf;
	}

	/**
	 * @return HTML2PDF
	 */
	public function HTML2PDF()
	{
		$args=func_get_args();
		$this->initLibrary(__FUNCTION__, $args);
		return $this->_HTML2PDF;
	}
}

/**
 * The EYiiPdfException exception class.
 * @author Borales <bordun.alexandr@gmail.com>
 * @package application.extensions.yii-pdf.EYiiPdf
 * @version 0.1
 */
class EYiiPdfException extends CException {}