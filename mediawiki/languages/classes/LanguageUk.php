<?php
/**
 * Ukrainian (українська мова) specific code.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Language
 */

/**
 * Ukrainian (українська мова)
 *
 * @ingroup Language
 */
class LanguageUk extends Language {

	/**
	 * Convert from the nominative form of a noun to some other case
	 * Invoked with {{grammar:case|word}}
	 *
	 * @param $word string
	 * @param $case string
	 * @return string
	 */
	function convertGrammar( $word, $case ) {
		global $wgGrammarForms;
		if ( isset( $wgGrammarForms['uk'][$case][$word] ) ) {
			return $wgGrammarForms['uk'][$case][$word];
		}

		# These rules are not perfect, but they are currently only used for site names so it doesn't
		# matter if they are wrong sometimes. Just add a special case for your site name if necessary.

		# join and array_slice instead mb_substr
		$ar = array();
		preg_match_all( '/./us', $word, $ar );
		if ( !preg_match( "/[a-zA-Z_]/us", $word ) ) {
			switch ( $case ) {
				case 'genitive': # родовий відмінок
					if ( ( join( '', array_slice( $ar[0], -4 ) ) == 'вікі' ) || ( join( '', array_slice( $ar[0], -4 ) ) == 'Вікі' ) ) {
					} elseif ( join( '', array_slice( $ar[0], -1 ) ) == 'ь' ) {
						$word = join( '', array_slice( $ar[0], 0, -1 ) ) . 'я';
					} elseif ( join( '', array_slice( $ar[0], -2 ) ) == 'ія' ) {
						$word = join( '', array_slice( $ar[0], 0, -2 ) ) . 'ії';
					} elseif ( join( '', array_slice( $ar[0], -2 ) ) == 'ка' ) {
						$word = join( '', array_slice( $ar[0], 0, -2 ) ) . 'ки';
					} elseif ( join( '', array_slice( $ar[0], -2 ) ) == 'ти' ) {
						$word = join( '', array_slice( $ar[0], 0, -2 ) ) . 'тей';
					} elseif ( join( '', array_slice( $ar[0], -2 ) ) == 'ди' ) {
						$word = join( '', array_slice( $ar[0], 0, -2 ) ) . 'дів';
					} elseif ( join( '', array_slice( $ar[0], -3 ) ) == 'ник' ) {
						$word = join( '', array_slice( $ar[0], 0, -3 ) ) . 'ника';
					}
					break;
				case 'dative':  # давальний відмінок
					# stub
					break;
				case 'accusative': # знахідний відмінок
					if ( ( join( '', array_slice( $ar[0], -4 ) ) == 'вікі' ) || ( join( '', array_slice( $ar[0], -4 ) ) == 'Вікі' ) ) {
					} elseif ( join( '', array_slice( $ar[0], -2 ) ) == 'ія' ) {
						$word = join( '', array_slice( $ar[0], 0, -2 ) ) . 'ію';
					}
					break;
				case 'instrumental':  # орудний відмінок
					# stub
					break;
				case 'prepositional': # місцевий відмінок
					# stub
					break;
			}
		}
		return $word;
	}

	/**
	 * Ukrainian numeric format is "12 345,67" but "1234,56"
	 *
	 * @param $_ string
	 *
	 * @return string
	 */
	function commafy( $_ ) {
		if ( !preg_match( '/^\-?\d{1,4}(\.\d+)?$/', $_ ) ) {
			return strrev( (string)preg_replace( '/(\d{3})(?=\d)(?!\d*\.)/', '$1,', strrev( $_ ) ) );
		} else {
			return $_;
		}
	}
}
