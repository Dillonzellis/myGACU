<?php
@header("content-type: text/html; charset=utf-8");
define("CQUERYMAXQUERYSIZE",1024*5);
define("CQUERYMINQUERYSIZE",10);
define("CQUERYMAXSCREENSIZE",500);
define("CSPECIALCHARS",91);
define("NEWSPECIALCHARSIZE",14);
define("OLDSPECIALCHARACTERSSIZE",300);
define("MAXKEYWORD",256);
define("MAXSTR",2048);
define("CONTENTS_KEYWORD_LIMIT_SOURCE",3000);
define("CONTENTS_KEYWORD_LIMIT_TARGET",30);
define("CONTENTS_NEIGHBORING_KEYWORDS_BOOST",10);
define("KEYWORDDBNAME","db1.sdb");
define("URLDBNAME","db2.sdb");
define("SBKPOSTINGSDBNAME","db13.sdb");
define("KEYWORDINDEXDBNAME","db5.sdb");
define("URLINDEXDBNAME","db6.sdb");
define("CONTENTSDBNAME","db7.sdb");
define("CONTENTSINDEXDBNAME","db8.sdb");
define("KEYWORDINDEX2DBNAME","db9.sdb");
define("POSITIONSBYURLINDEX1DBNAME","db10.sdb");
define("POSITIONSBYURLINDEX2DBNAME","db11.sdb");
define("POSITIONSBYURLDBNAME","db12.sdb");
define("SEARCHINDEX_STRFUNC",1);
define("STRCACHESIZE",50*1024);
define("POSTINGSCACHESIZE",4*1024);
define("CODEPAGE_ANSI",28591);
define("CODEPAGE_UTF8",65001);
define("RECORD_URLINDEX",1);
define("RECORD_CHAR",2);
define("RECORD_24_8",3);
define("RECORD_24_32",4);
define("RECORD_24_8_8",5);
define("RECORD_16",6);
define("RECORD_24_32_64",7);
define("SIZE_FLAG_BYTES",0);
define("SIZE_FLAG_KBYTES",1);
define("SIZE_FLAG_MBYTES",2);
define("SIZE_FLAG_GBYTES",3);
define("SORT_SCORE",0);
define("SORT_URL",1);
define("SORT_TYPE",2);
define("SORT_SIZE",3);
define("SORT_DATE",4);
define("DOC_NONE",0);
define("DOC_PDF",1);
define("DOC_DOC",2);
define("DOC_XLS",4);
define("DOC_PPT",8);
define("DOC_OTHER",16);
define("DOC_MEDIA",32);
define("DOC_ARCHIVE",64);
define("SCORE_OR_BOTH_FOUND_MULT",2);
define("SCORE_OR_BOTH_FOUND_FIXED",5);
define("SETTINGS_FILENAME","sessearch.t");
define("FONTINFOSIZE",128);
define("FONTENDINFOSIZE",16);
define("PREFIXSIZE",11);
define("NFONTS",5);
define("BINDATASIZE",20);
define("NSTRINGS",7);
define("STRINGSIZE",256);
define("LONGSTRINGSIZE",2048);
define("RESULTFORMATSIZE",(1024*16));
define("RESULTOVERVIEWSIZE",(1024*16));
define("RESULTBUFFERMAXSIZE",(1024*16));
define("FONT1STR_OFF",PREFIXSIZE+NFONTS*FONTENDINFOSIZE);
define("FONT1ENDSTR_OFF",PREFIXSIZE);
define("ENDFONT_OFF",PREFIXSIZE+NFONTS*FONTENDINFOSIZE+NFONTS*FONTINFOSIZE);
define("MAXRESULTS_OFF",ENDFONT_OFF+2);
define("MINLEN_OFF",ENDFONT_OFF+8);
define("NORESULTSSTR_OFF",ENDFONT_OFF+BINDATASIZE+5*STRINGSIZE);
define("DEFAULTFRAME_OFF",ENDFONT_OFF+BINDATASIZE+6*STRINGSIZE);
define("SPECIALCHARACTERS_OFF",FONT1STR_OFF+NFONTS*FONTINFOSIZE+BINDATASIZE);
define("NEWDATAOFFSET",ENDFONT_OFF+BINDATASIZE+NSTRINGS*STRINGSIZE+OLDSPECIALCHARACTERSSIZE+LONGSTRINGSIZE);
define("RESULTFORMATTEXT_OFF",NEWDATAOFFSET);
define("CONTENTPREVIEWBLOCKCOUNT_OFF",NEWDATAOFFSET+RESULTFORMATSIZE);
define("CONTENTPREVIEWBLOCKSIZE_OFF",NEWDATAOFFSET+RESULTFORMATSIZE+1);
define("RESULTOVERVIEWTEXT_OFF",NEWDATAOFFSET+RESULTFORMATSIZE+2);
define("SEGMENT64OFFSET",PREFIXSIZE+FONTENDINFOSIZE);
define("BDEMO_OFF",SEGMENT64OFFSET+3);
define("LOG_OFF",FONT1STR_OFF+FONTINFOSIZE);
define("SECTIONSSIZE_OFF",FONT1STR_OFF+FONTINFOSIZE+128+256);
define("SECTIONSCOUNT_OFF",FONT1STR_OFF+FONTINFOSIZE+128+256+1);
set_magic_quotes_runtime(0);
class SearchInfo{
var $settingsDB;
var $keywordDB;
var $keywordIndexDB;
var $URLDB;
var $URLIndexDB;
var $keywordIndex2DB;
var $SBKPostingsDB;
var $contentsIndexDB;
var $contentsDB;
var $keywordList;
var $resultList;
var $resultListSorted;
var $bDemoVersion;
var $positionsByURLDB;
var $positionsByURLIndex1DB;
var $positionsByURLIndex2DB;}
class IndexPosInfo{
var $startPos;
var $endPos;}
class SDBInfo{
var $file;
var $size;
var $pos;
var $recordSize;
var $recordType;
var $cacheStart;
var $cacheSize;
var $cache;}
class KeywordInfo{
var $ID;
var $keyword;
var $filter;
var $expressionPos;
var $bExpressionEnd;}
class TopPosInfo{
var $nKeyword;
var $topValue;}
class URLBaseInfo{
var $dateYear;
var $dateMonth;
var $dateDay;
var $sizeMain;
var $sizeFlags;
var $sizeFraction;}
class SingleExpressionInfo{
var $keywordID;
var $currentPos;
var $currentValue;
var $rec;
var $keywordInfo;
};
class URLIndexInfo extends URLBaseInfo{
var $startPos;
var $endPos;
};
class ResultInfo extends URLBaseInfo{
var $score;
var $URL;
var $URLID;
var $title;
var $description;
var $docType;
var $sections;}
class SearchFilter{
var $validDocTypes;
var $prevValidDayCount;
var $URLGroup;
var $bDefaultAnd;
var $bPhraseMode;
var $startDateYear;
var $startDateMonth;
var $startDateDay;
var $endDateYear;
var $endDateMonth;
var $endDateDay;}
class SearchIndex_StrInfo{
var $stringDB;
var $searchString;}
class Bitfield24_32Record{
var $data24;
var $data32;}
class Bitfield24_32_64Record{
var $data24;
var $data32;
var $data64;}
class Bitfield24_8Record{
var $data24;
var $data8;}
class Bitfield24_8_8Record{
var $data24;
var $data8_1;
var $data8_2;}
class Bitfield16Record{
var $data8_1;
var $data8_2;}
class URLIndexRecord extends URLBaseInfo{
var $data24;
var $data32;}
class KeywordLocationInfo{
var $ID;
var $position;
var $score;
var $bDisplayed;
var $expressionPos;
var $bExpressionEnd;
var $bMarkBold;
var $prevKeywordPosition;
var $postingIt;}
class KeywordIterationCache{
var $offset;
var $cachePtr;
var $urlId;}
class SearchParams{
var $queryString;
var $count;
var $first;
var $prefixString;
var $sortType;
var $searchFilter;
var $scriptName;
var $originalQueryString;}
class SBKPostingIterator{
var $offset;
var $lastOffset;
var $prevURLId;
var $lastURLId;
var $keywordId;
var $prevScore;
var $prevSection;
var $cacheContents;
var $cacheSize;
var $cachePtr;
var $URLCount;}
function InitializeSBKPosting(&$hsdb,$startOffset,$keywordId,&$iterator){
$iterator->offset=$startOffset+20;
$iterator->prevURLId=0;
$iterator->keywordId=$keywordId;
SDBSeek($hsdb,$startOffset+8);
$iterator->lastOffset=$startOffset+8+Read32($hsdb)-1;
$iterator->lastURLId=Read32($hsdb);
$iterator->URLCount=Read32($hsdb);
$iterator->cacheSize=0;
$iterator->cachePtr=0;
RefreshSBKCache($hsdb,$iterator);}
function RefreshSBKCache(&$hsdb,&$iterator){
if($iterator->cacheSize-$iterator->cachePtr<6){
SDBSeek($hsdb,$iterator->offset);
$iterator->cacheContents=fread($hsdb->file,POSTINGSCACHESIZE);
$iterator->cacheSize=strlen($iterator->cacheContents);
$iterator->cachePtr=0;}}
function ReadVariableSizeInt(&$iterator,&$size){
$val=0;
$nByte=0;
do{
$byte=@ord($iterator->cacheContents [$iterator->cachePtr]);
$iterator->cachePtr++;
$val=$val |(($byte&127)<<($nByte*7));
$nByte++;
}while($byte&128);
$size=$nByte;
return $val;}
function ReadSectionsIntoLong(&$data,$offset,$byteCount){
$retval=0;
for($i=$byteCount-1;$i>=0;$i--){
$retval=($retval<<8)| @ord($data [$offset+$i]);}
return $retval;}
function ReadSBKPosting(&$hsdb,&$iterator,&$id,&$score,&$section){
global $sectionsSize;
RefreshSBKCache($hsdb,$iterator);
$skipped=0;
$iterator->prevURLId+=ReadVariableSizeInt($iterator,$skipped);
$iterator->prevScore=@ord($iterator->cacheContents [$iterator->cachePtr]);
$iterator->prevSection=ReadSectionsIntoLong($iterator->cacheContents,$iterator->cachePtr+1,$sectionsSize);
$iterator->cachePtr+=1+$sectionsSize;
$id=$iterator->prevURLId;
$score=$iterator->prevScore;
$section=$iterator->prevSection;
$iterator->offset+=$skipped+1+$sectionsSize;}
function Read8(&$hsdb){
$data=fread($hsdb->file,1);
return @ord($data [0]);}
function Read24(&$hsdb){
$data=fread($hsdb->file,3);
$num=(@ord($data [2])<<16)|(@ord($data [1])<<8)| @ord($data [0]);
return $num;}
function Read32(&$hsdb){
$data=fread($hsdb->file,4);
$num=(@ord($data [3])<<24)|(@ord($data [2])<<16)|(@ord($data [1])<<8)| @ord($data [0]);
return $num;}
function Read64(&$hsdb){
$data=fread($hsdb->file,8);
$num=
(@ord($data [3])<<24)|(@ord($data [2])<<16)|(@ord($data [1])<<8)| @ord($data [0]);
return $num;}
function Read16(&$hsdb){
$data=fread($hsdb->file,2);
$num=(@ord($data [1])<<8)|(@ord($data [0]));
return $num;}
function SDBGet(&$hsdb,&$record){
switch($hsdb->recordType){
case RECORD_CHAR:
$record=chr(Read8($hsdb));
break;
case RECORD_24_32:
$record=new Bitfield24_32Record;
$record->data24=Read24($hsdb);
Read8($hsdb);
$record->data32=Read32($hsdb);
break;
case RECORD_24_32_64:
$record=new Bitfield24_32_64Record;
$record->data24=Read24($hsdb);
Read8($hsdb);
$record->data32=Read32($hsdb);
$record->data64=Read64($hsdb);
break;
case RECORD_24_8:
$record=new Bitfield24_8Record;
$record->data24=Read24($hsdb);
$record->data8=Read8($hsdb);
break;
case RECORD_16:
$record=new Bitfield16Record;
$record->data8_1=Read8($hsdb);
$record->data8_2=Read8($hsdb);
break;
case RECORD_24_8_8:
$record=new Bitfield24_8_8Record;
$record->data24=Read24($hsdb);
$record->data8_1=Read8($hsdb);
$record->data8_2=Read8($hsdb);
break;
case RECORD_URLINDEX:
$record=new URLIndexRecord;
$record->data24=Read24($hsdb);
$dat8=Read8($hsdb);
$record->sizeFlags=($dat8&0x03);
$record->sizeFraction=($dat8&0x3C)>>2;
$record->data32=Read32($hsdb);
$dat16_1=Read16($hsdb);
$dat16_2=Read16($hsdb);
$record->dateYear=($dat16_1&0x0FFF);
$record->dateMonth=($dat16_1&0xF000)>>12;
$record->dateDay=($dat16_2&0x001F);
$record->sizeMain=($dat16_2&0xFFE0)>>5;
break;}
$hsdb->pos=$hsdb->pos+1;
return TRUE;}
function SDBSeek(&$hsdb,$pos){
if($pos>$hsdb->size || $pos<0)
return FALSE;
fseek($hsdb->file,$hsdb->recordSize*$pos,SEEK_SET);
$hsdb->pos=$pos;
return TRUE;}
function SDBGetAt(&$hsdb,$pos,&$record){
if(SDBSeek($hsdb,$pos)==FALSE)
return FALSE;
return SDBGet($hsdb,$record);}
function CompareRecords(&$value,&$record,$compareFunc){
if(SDBSeek($value->stringDB,$record->data32)){
$searchCh=0;
$searchStr=$value->searchString;
$searchStr .=chr(0);
while(TRUE){
SDBGet($value->stringDB,$ch);
$dif=ord($searchStr [$searchCh])-ord($ch);
if($dif<0)
return-1;
else if($dif>0)
return 1;
if(ord($ch)==0 || ord($searchStr [$searchCh])==0 || $searchCh>=MAXSTR)
break;
$searchCh=$searchCh+1;}
if(ord($ch)==0&&ord($searchStr [$searchCh])!=0){
return 1;}
if(ord($ch)!=0&&ord($searchStr [$searchCh])==0){
return-1;}
return 0;}
return-1;}
function SDBBinarySearchInt24_32(&$hsdb,&$value,&$record,$first,$last,&$insertPos){
$record=new Bitfield24_32Record;
$mid=0;
while($first<=$last){
$mid=(int)($first+($last-$first)/2);
fseek($hsdb->file,8*$mid,SEEK_SET);
$record->data24=Read24($hsdb);
$res=$value-$record->data24;
if($res==0){
Read8($hsdb);
$record->data32=Read32($hsdb);
$insertPos=$mid;
$hsdb->pos=$mid+1;
return $mid;}
if($res<0){
$last=$mid-1;}
else{
$first=$mid+1;}}
Read8($hsdb);
$record->data32=Read32($hsdb);
$insertPos=$first;
$hsdb->pos=$mid+1;
return-1;}
function SDBBinarySearchIntURLIndex(&$hsdb,&$value,&$record,$first,$last,&$insertPos){
$record=new URLIndexRecord;
$mid=0;
while($first<=$last){
$mid=(int)($first+($last-$first)/2);
fseek($hsdb->file,12*$mid,SEEK_SET);
$record->data24=Read24($hsdb);
$res=$value-$record->data24;
if($res==0){
$dat8=Read8($hsdb);
$record->sizeFlags=($dat8&0x03);
$record->sizeFraction=($dat8&0x3C)>>2;
$record->data32=Read32($hsdb);
$dat16_1=Read16($hsdb);
$dat16_2=Read16($hsdb);
$record->dateYear=($dat16_1&0x0FFF);
$record->dateMonth=($dat16_1&0xF000)>>12;
$record->dateDay=($dat16_2&0x001F);
$record->sizeMain=($dat16_2&0xFFE0)>>5;
$insertPos=$mid;
$hsdb->pos=$mid+1;
return $mid;}
if($res<0){
$last=$mid-1;}
else{
$first=$mid+1;}}
$dat8=Read8($hsdb);
$record->sizeFlags=($dat8&0x03);
$record->sizeFraction=($dat8&0x3C)>>2;
$record->data32=Read32($hsdb);
$dat16_1=Read16($hsdb);
$dat16_2=Read16($hsdb);
$record->dateYear=($dat16_1&0x0FFF);
$record->dateMonth=($dat16_1&0xF000)>>12;
$record->dateDay=($dat16_2&0x001F);
$record->sizeMain=($dat16_2&0xFFE0)>>5;
$insertPos=$first;
$hsdb->pos=$mid+1;
return-1;}
function SDBBinarySearchInt24_8_8(&$hsdb,&$value,&$record,$first,$last,&$insertPos){
$record=new Bitfield24_8_8Record;
$mid=0;
while($first<=$last){
$mid=(int)($first+($last-$first)/2);
fseek($hsdb->file,5*$mid,SEEK_SET);
$record->data24=Read24($hsdb);
$res=$value-$record->data24;
if($res==0){
$record->data8_1=Read8($hsdb);
$record->data8_2=Read8($hsdb);
$insertPos=$mid;
$hsdb->pos=$mid+1;
return $mid;}
if($res<0){
$last=$mid-1;}
else{
$first=$mid+1;}}
$record->data8_1=Read8($hsdb);
$record->data8_2=Read8($hsdb);
$insertPos=$first;
$hsdb->pos=$mid+1;
return-1;}
function SDBBinarySearch(&$hsdb,&$value,&$record,$first,$last,&$insertPos,$compareFunc){
while($first<=$last){
$mid=(int)($first+($last-$first)/2);
SDBGetAt($hsdb,$mid,$record);
$res=CompareRecords($value,$record,$compareFunc);
if($res==0){
$insertPos=$mid;
return $mid;}
if($res<0){
$last=$mid-1;}
else{
$first=$mid+1;}}
$insertPos=$first;
return-1;}
function IsTerminatingCharacter($char,$codepage){
$ch=ord($char);
if($ch==0x7B || $ch==0x7D)
return FALSE;
if(($ch>=0&&$ch<=38)||
($ch>=39&&$ch<=47)||($ch>=58&&$ch<=64)||
($ch>=91&&$ch<=94)|| $ch==96 ||($ch>=123&&$ch<=126))
return TRUE;
if($codepage !=CODEPAGE_UTF8){
if(($ch>=128&&$ch<=191))
return TRUE;}
return FALSE;}
function CheckSpecialCharacter(&$str,$pos,&$translatedText,&$specialChars,&$skipChars){
if(!$specialChars || ord($specialChars [0])==0)
return FALSE;
$len=strlen($str);
for($i=0;$i<CSPECIALCHARS;$i++){
$skipChars=0;
$curPos=$pos;
if(ord($specialChars [$i*NEWSPECIALCHARSIZE])==0)
break;
$j=0;
while($curPos<$len&&$specialChars [$i*NEWSPECIALCHARSIZE+$j]==$str [$curPos]){
$skipChars++;
$curPos++;
$j++;}
if(ord($specialChars [$i*NEWSPECIALCHARSIZE+$j])==0){
$translatedText='';
$j=$i*NEWSPECIALCHARSIZE+(NEWSPECIALCHARSIZE/2);
while(ord($specialChars [$j])!=0){
$translatedText .=$specialChars [$j];
$j++;}
return TRUE;}}
return FALSE;}
function SearchParseKeywords($keywords,&$keywordList,$minKeywordLength,&$specialChars,$codepage,$bPhraseMode){
$word='';
$keywords .=chr(0);
$len=strlen($keywords);
$filter=0;
for($i=0;$i<$len;$i++){
$wordlen=strlen($word);
$special=NULL;
$skipChars=0;
if(CheckSpecialCharacter($keywords,$i,$special,$specialChars,$skipChars)==FALSE&&
(($wordlen>MAXKEYWORD-1)|| $keywords [$i]==' ' || IsTerminatingCharacter($keywords [$i],$codepage))){
if(strtoupper(substr($word,0,3))=='{QF'){
$filter=(int)substr($word,3);}
else if($wordlen>=$minKeywordLength){
$newKeyword=new KeywordInfo;
$newKeyword->keyword=$word;
$newKeyword->ID=0;
$newKeyword->endFilePos=-1;
$newKeyword->filter=$filter;
$newKeyword->postingIt=new SBKPostingIterator;
if($bPhraseMode){
$newKeyword->expressionPos=1+count($keywordList);
$newKeyword->bExpressionEnd=FALSE;}
else{
$newKeyword->expressionPos=0;
$newKeyword->bExpressionEnd=FALSE;}
$keywordList []=$newKeyword;}
$word='';}
else{
if($special){
$word .=$special;
$i+=$skipChars-1;}
else{
$word .=(ord($keywords [$i])<128 ? strtolower($keywords [$i]): $keywords [$i]);}}}
if($bPhraseMode&&count($keywordList)>0){
$keywordList [count($keywordList)-1]->bExpressionEnd=TRUE;}}
function MakeLowerUtfSafe(&$str){
$len=strlen($str);
for($i=0;$i<$len;$i++){
if(ord($str [$i])<128)
$str [$i]=strtolower($str [$i]);}}
function SearchFindStringIdFromName($searchString,&$id,&$indexDB,&$stringDB,&$record){
$searchInfo=new SearchIndex_StrInfo;
$searchInfo->stringDB=$stringDB;
$searchInfo->searchString=$searchString;
MakeLowerUtfSafe($searchInfo->searchString);
$pos=SDBBinarySearch($indexDB,$searchInfo,$record,0,$indexDB->size-1,$dummy,SEARCHINDEX_STRFUNC);
if($pos==-1){
return FALSE;}
$id=$record->data24;
return TRUE;}
function SearchFindPosIn24_32IndexEx(&$info,&$hsdb,$ID,&$indexPos,$first,$last){
$info=new IndexPosInfo;
$pos=SDBBinarySearchInt24_32($hsdb,$ID,$record,$first,$last,$insertPos);
if($pos==-1){
$info->startPos=-1;
return FALSE;}
$indexPos=$insertPos;
$info->startPos=$record->data32;
if($hsdb->pos==$hsdb->size){
$info->endPos=-1;
return TRUE;}
SDBGet($hsdb,$record);
$info->endPos=$record->data32;
return TRUE;}
function SearchFindPosInURLIndex(&$info,&$hsdb,$ID){
$info=new URLIndexInfo;
$pos=SDBBinarySearchIntURLIndex($hsdb,$ID,$record,0,$hsdb->size-1,$dummy);
if($pos==-1){
$info->startPos=-1;
return FALSE;}
$info->startPos=$record->data32;
$info->dateYear=$record->dateYear;
$info->dateMonth=$record->dateMonth;
$info->dateDay=$record->dateDay;
$info->sizeFlags=$record->sizeFlags;
$info->sizeFraction=$record->sizeFraction;
$info->sizeMain=$record->sizeMain;
if($hsdb->pos==$hsdb->size){
$info->endPos=-1;
return TRUE;}
SDBGet($hsdb,$record);
$info->endPos=$record->data32;
return TRUE;}
function ReadStringFromCache(&$hsdb,&$outputString,$startPos){
if($startPos>=$hsdb->cacheStart&&$startPos<$hsdb->cacheStart+$hsdb->cacheSize){
$pos=$startPos-$hsdb->cacheStart;
$ch=$hsdb->cache [$pos];
$endpos=strpos($hsdb->cache,chr(0),$pos);
if($endpos !==FALSE){
$outputString=substr($hsdb->cache,$pos,$endpos-$pos);
return TRUE;}
else{
return FALSE;}}
return FALSE;}
function SetCache(&$hsdb,$startPos){
SDBSeek($hsdb,$startPos);
$hsdb->cache=fread($hsdb->file,STRCACHESIZE);
$hsdb->cacheStart=$startPos;
$hsdb->cacheSize=strlen($hsdb->cache);}
function SearchReadString(&$hsdb,&$outputString,$startPos){
if(ReadStringFromCache($hsdb,$outputString,$startPos)==FALSE){
SetCache($hsdb,$startPos);
ReadStringFromCache($hsdb,$outputString,$startPos);}}
function isalpha($c){
return(($c>='a'&&$c<='z')||($c>='A'&&$c<='Z'));}
function strposi($haystackOrig,$needle,$offset=0,$bWholeWordOnly=FALSE){
$haylenOrig=strlen($haystackOrig);
$haystack=substr($haystackOrig,$offset,$haylenOrig);
$haylen=strlen($haystack);
if($haystack===FALSE)
return FALSE;
$temp=stristr($haystack,$needle);
$pos=$haylen-strlen($temp);
if($pos==$haylen)
$pos=FALSE;
else
$pos+=$offset;
if($bWholeWordOnly&&$pos !==FALSE){
$needlelen=strlen($needle);
if(($pos>0&&isalpha($haystackOrig [$pos-1]))||
($pos+$needlelen<$haylenOrig&&isalpha($haystackOrig [$pos+$needlelen])))
return strposi($haystackOrig,$needle,$pos+strlen($needle),TRUE);}
return $pos;}
function FindStringInList(&$str,&$list,$sep){
$chunks=explode($sep,$list);
foreach($chunks as $chunk){
$foundPos=strposi($str,$chunk);
if($foundPos !==FALSE&&$foundPos==0){
return TRUE;}}
return FALSE;}
function SearchCheckDateFilter(&$si,&$result,&$searchFilter){
if($searchFilter->startDateYear>0){
if(CompareDates($result->dateYear,$result->dateMonth,$result->dateDay,
$searchFilter->startDateYear,$searchFilter->startDateMonth,$searchFilter->startDateDay)<0)
return false;}
if($searchFilter->endDateYear>0){
if(CompareDates($result->dateYear,$result->dateMonth,$result->dateDay,
$searchFilter->endDateYear,$searchFilter->endDateMonth,$searchFilter->endDateDay)>0)
return false;}
return true;}
function SearchCheckFilter(&$si,&$result,&$searchFilter){
if($searchFilter->prevValidDayCount){
if(IsDocumentRecent($result->dateYear,$result->dateMonth,$result->dateDay,$searchFilter->prevValidDayCount)==FALSE){
return FALSE;}}
if($searchFilter->validDocTypes){
$type=$result->docType;
if(($searchFilter->validDocTypes&$type)==0){
return FALSE;}}
if(is_string($searchFilter->URLGroup)&&strlen($searchFilter->URLGroup)>0){
$url=$result->URL;
if($si->bDemoVersion){
$desPos=strpos($result->URL,'url=');
if($desPos !==FALSE)$url=substr($result->URL,4);}
if(FindStringInList($url,$searchFilter->URLGroup,'*')==FALSE){
return FALSE;}}
if(SearchCheckDateFilter($si,$result,$searchFilter)==FALSE){
return FALSE;}
return TRUE;}
function SearchAddResult(&$si,$URLID,$score,&$searchFilter){
if(SearchFindPosInURLIndex($indexInfo,$si->URLIndexDB,$URLID)==FALSE){
return FALSE;}
$result=new ResultInfo;
$result->dateYear=$indexInfo->dateYear;
$result->dateMonth=$indexInfo->dateMonth;
$result->dateDay=$indexInfo->dateDay;
$result->sizeFlags=$indexInfo->sizeFlags;
$result->sizeFraction=$indexInfo->sizeFraction;
$result->sizeMain=$indexInfo->sizeMain;
SearchReadString($si->URLDB,$result->URL,$indexInfo->startPos);
$result->URLID=$URLID;
$result->score=$score;
$result->docType=SearchGetDocTypeFromURL($result->URL,$si->bDemoVersion==FALSE);
if(SearchCheckFilter($si,$result,$searchFilter)){
$si->resultList []=$result;}
return TRUE;}
function GetCombinedSize($sizeMain,$sizeFraction,$sizeFlags){
$size=$sizeMain*10+$sizeFraction;
switch($sizeFlags){
case SIZE_FLAG_BYTES:
return $size/10;
case SIZE_FLAG_KBYTES:
return $size*100;
case SIZE_FLAG_MBYTES:
return $size*100000;
case SIZE_FLAG_GBYTES:
return $size*100000000;}
return 0;}
function CompareDates($dateYear1,$dateMonth1,$dateDay1,$dateYear2,$dateMonth2,$dateDay2){
if($dateYear1==$dateYear2){
if($dateMonth1==$dateMonth2){
if($dateDay1==$dateDay2){
return 0;}
return $dateDay1-$dateDay2;}
return $dateMonth1-$dateMonth2;}
return $dateYear1-$dateYear2;}
function ResultSortByScore(&$a,&$b){
if($a->score==$b->score)return 0;
return($a->score>$b->score)?-1 : 1;}
function ResultSortByType(&$a,&$b){
$res=$a->docType-$b->docType;
if($res==0)
return ResultSortByScore($a,$b);
return $res;}
function ResultSortBySize(&$a,&$b){
$res=GetCombinedSize($b->sizeMain,$b->sizeFraction,$b->sizeFlags)-
GetCombinedSize($a->sizeMain,$a->sizeFraction,$a->sizeFlags);
if($res==0)
return ResultSortByScore($a,$b);
return $res;}
function ResultSortByDate(&$a,&$b){
$res=CompareDates($b->dateYear,$b->dateMonth,$b->dateDay,$a->dateYear,$a->dateMonth,$a->dateDay);
if($res==0)
return ResultSortByScore($a,$b);
return $res;}
function ResultSortByURLName(&$a,&$b){
$res=strcasecmp($a->URL,$b->URL);
if($res==0)
return ResultSortByScore($a,$b);
return $res;}
function AdvSearchCheckSingleExpression(&$si,$URLID,&$expressionList){
if(SDBIsInitialized($si->positionsByURLDB)==FALSE ||
SDBIsInitialized($si->positionsByURLIndex1DB)==FALSE ||
SDBIsInitialized($si->positionsByURLIndex2DB)==FALSE){
return TRUE;}
if(count($expressionList)>0){
if(SearchFindPosIn24_32IndexEx($urlInfo,$si->positionsByURLIndex1DB,$URLID,$dummy,0,$si->positionsByURLIndex1DB->size-1)){
if($urlInfo->endPos==-1){
$urlInfo->endPos=$si->positionsByURLIndex2DB->size;}
for($nKeyword=0;$nKeyword<count($expressionList);$nKeyword++){
$expressionInfo=&$expressionList [$nKeyword];
if(SearchFindPosIn24_32IndexEx($expressionInfo->keywordInfo,$si->positionsByURLIndex2DB,
$expressionInfo->keywordID,$dummy,$urlInfo->startPos,$urlInfo->endPos-1)){
if($expressionInfo->keywordInfo->endPos==-1){
$expressionInfo->keywordInfo->endPos=$si->positionsByURLDB->size;}
$expressionInfo->currentPos=$expressionInfo->keywordInfo->startPos;
if(SDBGetAt($si->positionsByURLDB,$expressionInfo->currentPos,$expressionInfo->rec)==FALSE){
return FALSE;}
$expressionInfo->currentValue=((int)$expressionInfo->rec->data8_1+256*(int)$expressionInfo->rec->data8_2)+count($expressionList)-$nKeyword-1;}}
while(TRUE){
$searchedPos=-1;
$minPos=-1;
$minPosIndex=-1;
unset($minPosInfo);
for($nKeyword=0;$nKeyword<count($expressionList);$nKeyword++){
$expressionInfo=&$expressionList [$nKeyword];
if($expressionInfo->currentPos>=$expressionInfo->keywordInfo->endPos){
return FALSE;}
if($nKeyword==0){
$searchedPos=$expressionInfo->currentValue;}
else{
if($searchedPos !=$expressionInfo->currentValue){
$searchedPos=-1;}}
if($minPos==-1 || $expressionInfo->currentValue<$minPos){
$minPos=$expressionInfo->currentValue;
$minPosInfo=&$expressionInfo;
$minPosIndex=$nKeyword;}}
if($searchedPos !=-1){
return TRUE;}
if(isset($minPosInfo)){
$minPosInfo->currentPos++;
if($minPosInfo->currentPos==$minPosInfo->keywordInfo->endPos){
return FALSE;}
if(SDBGetAt($si->positionsByURLDB,$minPosInfo->currentPos,$minPosInfo->rec)==FALSE){
return FALSE;}
$minPosInfo->currentValue=((int)$minPosInfo->rec->data8_1+256*(int)$minPosInfo->rec->data8_2)+count($expressionList)-$minPosIndex-1;}}}}
return FALSE;}
function GetKeywordIterationValues($iterator,&$iterationValues){
$iterationValues->offset=$iterator->offset;
$iterationValues->cachePtr=$iterator->cachePtr;
$iterationValues->urlId=$iterator->prevURLId;}
function BringBackKeywordIterationValues($iterationValues,&$iterator){
$iterator->offset=$iterationValues->offset;
$iterator->cachePtr=$iterationValues->cachePtr;
$iterator->prevURLId=$iterationValues->urlId;}
function SearchAnd(&$si,&$minHitsKeyword,$maxResults,&$searchFilter,&$expressionList){
do{
ReadSBKPosting($si->SBKPostingsDB,$minHitsKeyword->postingIt,$itId,$itScore,$itSection);
if($minHitsKeyword->filter==0 ||($itSection&$minHitsKeyword->filter)!=0){
$currentScore=$itScore;
$bSearchRecord=TRUE;
for($i=0;$i<count($si->keywordList);$i++){
$keyword=&$si->keywordList [$i];
if($keyword->ID !=$minHitsKeyword->ID){
$curSection=0;
$curId=0;
$curScore=0;
while($keyword->postingIt->offset<=$keyword->postingIt->lastOffset){
$iterationValuesCache=new KeywordIterationCache;
GetKeywordIterationValues($keyword->postingIt,$iterationValuesCache);
ReadSBKPosting($si->SBKPostingsDB,$keyword->postingIt,$curId,$curScore,$curSection);
if($curId>$itId){
BringBackKeywordIterationValues($iterationValuesCache,$keyword->postingIt);
$bSearchRecord=FALSE;
break;}
else if($curId==$itId){
break;}}
if($curId==0 || $bSearchRecord==FALSE ||($keyword->filter !=0&&($curSection&$keyword->filter)==0)){
$bSearchRecord=FALSE;
break;}
else{
$currentScore+=$curScore;}}}}
else{
$bSearchRecord=FALSE;}
if($bSearchRecord&&(!$searchFilter->bPhraseMode || AdvSearchCheckSingleExpression($si,$itId,$expressionList))){
if(SearchAddResult($si,$itId,$currentScore,$searchFilter)==FALSE)
return FALSE;
if(count($si->resultList)>=$maxResults)
break;}
}while($minHitsKeyword->postingIt->offset<=$minHitsKeyword->postingIt->lastOffset);
return TRUE;}
function TopPosSort(&$a,&$b){
if($a->topValue==NULL)
return 1;
if($b->topValue==NULL)
return-1;
return($a->topValue->prevURLId-$b->topValue->prevURLId);}
function UpdateTopPosItems(&$si,$firstPos,$lastPos,&$topPosItems){
for($i=$firstPos;$i<=$lastPos;$i++){
if($topPosItems [$i]->nKeyword !=-1){
ReadSBKPosting($si->SBKPostingsDB,$si->keywordList [$topPosItems [$i]->nKeyword]->postingIt,$itId,$itScore,$itSection);
$topPosItems [$i]->topValue=$si->keywordList [$topPosItems [$i]->nKeyword]->postingIt;}}
usort($topPosItems,"TopPosSort");
return TRUE;}
function SearchOr(&$si,$maxResults,&$searchFilter){
for($i=0;$i<count($si->keywordList);$i++){
if($si->keywordList [$i]->ID !=0){
$item=new TopPosInfo;
$item->nKeyword=$i;
$topPosItems []=$item;}}
$last=count($topPosItems)-1;
while($last>=0){
if(UpdateTopPosItems($si,0,$last,$topPosItems)==FALSE)
return FALSE;
$i=0;
$score=0;
$minValue=0;
for(;$i<count($topPosItems);$i++){
$val=&$topPosItems [$i]->topValue;
if($val==NULL)
break;
$keyword=&$si->keywordList [$topPosItems [$i]->nKeyword];
if($i==0)
$minValue=$val->prevURLId;
else if($minValue !=$val->prevURLId)
break;
if($keyword->filter==0 ||($val->prevSection&$keyword->filter)!=0)
$score+=$val->prevScore;
if($val->offset>$val->lastOffset){
$topPosItems [$i]->topValue=NULL;
$topPosItems [$i]->nKeyword=-1;}}
if($i>1){
$score*=SCORE_OR_BOTH_FOUND_MULT;
$score+=SCORE_OR_BOTH_FOUND_FIXED;}
$last=$i-1;
if($minValue>0&&SearchAddResult($si,$minValue,$score,$searchFilter)==FALSE)
return FALSE;
if(count($si->resultList)>=$maxResults)
break;}
return TRUE;}
function ReplaceEscapeSequences($str){
$ret='';
for($i=0;$i<strlen($str);$i++){
$c=ord($str [$i]);
if($c<0x80){
$ret .=chr($c);}
else{
$c1=chr(0xc0+($c/0x40));
$c2=chr(0x80+($c % 0x40));
$ret .=$c1;
$ret .=$c2;}}
return $ret;}
function SearchStart(&$si,$keywords,$maxResults,$minKeywordLength,&$specialChars,&$searchFilter,$sortFunc,$codepage){
$minHits=0;
$minHitsKeyword=NULL;
if($codepage==CODEPAGE_ANSI)
$keywords=ReplaceEscapeSequences($keywords);
SearchParseKeywords($keywords,$si->keywordList,$minKeywordLength,$specialChars,CODEPAGE_UTF8,$searchFilter->bPhraseMode);
for($i=0;$i<count($si->keywordList);$i++){
$keyword=&$si->keywordList [$i];
if(SearchFindStringIdFromName($keyword->keyword,$keywordId,$si->keywordIndexDB,$si->keywordDB,$keywordRecord)){
$keyword->ID=$keywordId;
InitializeSBKPosting($si->SBKPostingsDB,$keywordRecord->data64,$keyword->ID,$keyword->postingIt);
$tempLong=$keyword->postingIt->URLCount;
if($minHits==0 || $tempLong<$minHits){
$minHits=$tempLong;
$minHitsKeyword=&$keyword;}
if($searchFilter->bPhraseMode){
$exp=new SingleExpressionInfo;
$exp->keywordID=$keywordId;
$expressionList []=$exp;}}
else{
if($searchFilter->bDefaultAnd || count($si->keywordList)<2)
return FALSE;}}
if($minHitsKeyword==NULL){
return FALSE;}
if($searchFilter->bDefaultAnd || count($si->keywordList)<2){
if(SearchAnd($si,$minHitsKeyword,$maxResults,$searchFilter,$expressionList)==FALSE)
return FALSE;}
else{
if(SearchOr($si,$maxResults,$searchFilter)==FALSE)
return FALSE;}
if(count($si->resultList)>1){
usort($si->resultList,$sortFunc);}
return TRUE;}
function SDBInitialize(&$hsdb,$fname,$recordSize,$recordType){
$hsdb=new SDBInfo;
$hsdb->pos=0;
$hsdb->file=@fopen($fname,"rb");
if($hsdb->file==NULL){
return FALSE;}
fseek($hsdb->file,0,SEEK_END);
$hsdb->size=(int)(ftell($hsdb->file)/$recordSize);
fseek($hsdb->file,0,SEEK_SET);
$hsdb->recordType=$recordType;
$hsdb->recordSize=$recordSize;
$hsdb->cacheStart=0;
$hsdb->cacheSize=0;
return TRUE;}
function SDBIsInitialized(&$hsdb){
return $hsdb&&$hsdb->file;}
function SearchInitialize(&$si,$prefixString){
SDBInitialize($si->settingsDB,SETTINGS_FILENAME,1,RECORD_CHAR);
if(SDBInitialize($si->keywordDB,$prefixString . KEYWORDDBNAME,1,RECORD_CHAR)==FALSE ||
SDBInitialize($si->SBKPostingsDB,$prefixString . SBKPOSTINGSDBNAME,1,RECORD_CHAR)==FALSE ||
SDBInitialize($si->URLDB,$prefixString . URLDBNAME,1,RECORD_CHAR)==FALSE ||
SDBInitialize($si->URLIndexDB,$prefixString . URLINDEXDBNAME,12,RECORD_URLINDEX)==FALSE ||
SDBInitialize($si->keywordIndexDB,$prefixString . KEYWORDINDEXDBNAME,16,RECORD_24_32_64)==FALSE){
return FALSE;}
SDBInitialize($si->contentsIndexDB,$prefixString . CONTENTSINDEXDBNAME,8,RECORD_24_32);
SDBInitialize($si->contentsDB,$prefixString . CONTENTSDBNAME,4,RECORD_24_8);
SDBInitialize($si->keywordIndex2DB,$prefixString . KEYWORDINDEX2DBNAME,8,RECORD_24_32);
SDBInitialize($si->positionsByURLIndex1DB,$prefixString . POSITIONSBYURLINDEX1DBNAME,8,RECORD_24_32);
SDBInitialize($si->positionsByURLIndex2DB,$prefixString . POSITIONSBYURLINDEX2DBNAME,8,RECORD_24_32);
SDBInitialize($si->positionsByURLDB,$prefixString . POSITIONSBYURLDBNAME,2,RECORD_16);
return TRUE;}
function SearchCleanup(&$si){
fclose($si->settingsDB->file);
fclose($si->keywordDB->file);
fclose($si->SBKPostingsDB->file);
fclose($si->URLDB->file);
fclose($si->URLIndexDB->file);
fclose($si->keywordIndexDB->file);
fclose($si->contentsIndexDB->file);
fclose($si->contentsDB->file);
fclose($si->keywordIndex2DB->file);
fclose($si->positionsByURLDB->file);
fclose($si->positionsByURLIndex1DB->file);
fclose($si->positionsByURLIndex2DB->file);}
function MarkExpressionNonBold($expressionStart,$expressionEnd,&$keywordLocationList){
for($i=$expressionStart;$i<count($keywordLocationList)&&$i<=$expressionEnd;$i++){
$keywordLocationList [$i]->bMarkBold=FALSE;}}
function RemoveIncompleteExpressionsFromLocationList(&$keywordLocationList){
$prevInfo=NULL;
$expressionStart=-1;
for($i=0;$i<count($keywordLocationList);$i++){
unset($info);
$info=&$keywordLocationList [$i];
if(isset($prevInfo)&&$expressionStart !=-1){
if($info->expressionPos !=$prevInfo->expressionPos+1 ||
$info->prevKeywordPosition>$prevInfo->position){
if($info->expressionPos==1){
MarkExpressionNonBold($expressionStart,$i-1,$keywordLocationList);}
else{
MarkExpressionNonBold($expressionStart,$i,$keywordLocationList);}
$expressionStart=-1;}}
if($info->expressionPos>1&&$expressionStart==-1){
$info->bMarkBold=FALSE;}
else if($info->expressionPos==1){
$expressionStart=$i;}
else if($info->bExpressionEnd){
$expressionStart=-1;}
unset($prevInfo);
$prevInfo=&$info;}
if($expressionStart !=-1){
unset($info);
$info=&$keywordLocationList [count($keywordLocationList)-1];
if($info->bExpressionEnd==FALSE){
MarkExpressionNonBold($expressionStart,count($keywordLocationList)-1,$keywordLocationList);
$expressionStart=-1;}}}
function FindKeywordsInContents(&$si,$startPos,$keywordCount,&$keywordLocationList){
$insertedCount=0;
$keywordLocation=new KeywordLocationInfo;
$prevKeywordPosition=0;
$nextKeywordID=0;
$nextKeywordIterator=0;
if($startPos>=0&&$keywordCount>0&&SDBSeek($si->contentsDB,$startPos)){
$data=fread($si->contentsDB->file,min($keywordCount,CONTENTS_KEYWORD_LIMIT_SOURCE)*4);
$dataSize=strlen($data)/4;
for($i=0;$i<$dataSize;$i++){
$currentPosition=$startPos+$i;
if($insertedCount>=CONTENTS_KEYWORD_LIMIT_TARGET){
break;}
$keywordID=(@ord($data [$i*4+2])<<16)|(@ord($data [$i*4+1])<<8)| @ord($data [$i*4]);
$bKeyword=@ord($data [$i*4+3]);
if(($bKeyword&1)==1){
if($nextKeywordID !=0&&$nextKeywordID==$keywordID)
$startIt=$nextKeywordIterator;
else
$startIt=0;
$nextKeywordID=0;
for($j=$startIt;$j<count($si->keywordList);$j++){
$keywordInfo=&$si->keywordList [$j];
if($keywordInfo->ID==$keywordID&&$keywordID !=0){
if($keywordID !=0){
unset($keywordLocation);
$keywordLocation->ID=$keywordID;
$keywordLocation->position=$currentPosition;
$keywordLocation->score=0;
$keywordLocation->bDisplayed=FALSE;
$keywordLocation->expressionPos=$keywordInfo->expressionPos;
$keywordLocation->bExpressionEnd=$keywordInfo->bExpressionEnd;
$keywordLocation->bMarkBold=TRUE;
$keywordLocation->prevKeywordPosition=$prevKeywordPosition;
$keywordLocationList []=$keywordLocation;
$insertedCount++;
if($keywordInfo->expressionPos !=0){
$nextKeywordID=0;
if($j+1<count($si->keywordList)){
$nextKeywordID=$si->keywordList [$j+1]->ID;
$nextKeywordIterator=$j+1;}}
break;}}}
$prevKeywordPosition=$currentPosition;}}
RemoveIncompleteExpressionsFromLocationList($keywordLocationList);
if(count($keywordLocationList)==0){
unset($keywordLocation);
$keywordLocation->ID=0;
$keywordLocation->position=$startPos;
$keywordLocation->score=0;
$keywordLocation->bDisplayed=FALSE;
$keywordLocation->expressionPos=0;
$keywordLocation->bMarkBold=FALSE;
$keywordLocation->prevKeywordPosition=0;
$keywordLocationList []=$keywordLocation;}
return TRUE;}
return FALSE;}
function FilterKeywordsInContents($maxDescriptionLength,&$keywordLocationList){
global $contentPreviewBlockSize;
$maxScore=0;
$wordsLeft=$maxDescriptionLength;
$markNextKeywords=0;
$prevInfo=NULL;
$bAnythingMarkedBold=FALSE;
for($i=count($keywordLocationList)-1;$i>=0;$i--){
$keywordInfo=&$keywordLocationList [$i];
if($keywordInfo->bMarkBold)
$bAnythingMarkedBold=TRUE;
if($prevInfo !=NULL){
if($prevInfo->position-$keywordInfo->position<=$contentPreviewBlockSize){
$keywordInfo->score=$prevInfo->score+1;
if($prevInfo->position-$keywordInfo->position==1)
$keywordInfo->score+=CONTENTS_NEIGHBORING_KEYWORDS_BOOST;}
else{
$keywordInfo->score=1;}}
else{
$keywordInfo->score=1;}
if($keywordInfo->score>$maxScore){
$maxScore=$keywordInfo->score;}
$prevInfo=&$keywordInfo;}
for($i=$maxScore;$i>=1;$i--){
if($wordsLeft<=0){
break;}
for($j=0;$j<count($keywordLocationList);$j++){
$keywordInfo=&$keywordLocationList [$j];
if($keywordInfo&&($keywordInfo->bMarkBold || $bAnythingMarkedBold==FALSE)&&($keywordInfo->score==$i || $markNextKeywords>0)&&
$keywordInfo->bDisplayed==FALSE){
$keywordInfo->bDisplayed=TRUE;
$markNextKeywords=$keywordInfo->score-1;
$wordsLeft-=$contentPreviewBlockSize;
if($wordsLeft<=0){
break;}}}}
return TRUE;}
function SearchFindStringNameFromId($id,&$searchString,&$indexDB,&$stringDB,$bTranslated){
if(SearchFindPosIn24_32IndexEx($indexInfo,$indexDB,$id,$dummy,0,$indexDB->size-1)==FALSE){
return FALSE;}
$searchString='';
$pos=$indexInfo->startPos;
SearchReadString($stringDB,$searchString,$indexInfo->startPos);
if(!$bTranslated){
if($indexInfo->endPos==-1){
$indexInfo->endPos=$stringDB->size;}
$newStartPos=$indexInfo->startPos+strlen($searchString)+1;
if($newStartPos<$indexInfo->endPos){
SearchReadString($stringDB,$searchString,$newStartPos);}}
return TRUE;}
function IsAnsiString(&$word){
for($i=0;$i<strlen($word);$i++){
if(ord($word [$i])>=128)
return FALSE;}
return TRUE;}
function FixWordCase($wordCase,&$word){
if($word&&strlen($word)>0){
if($wordCase==3 || $wordCase==2){
if($wordCase==2&&ord($word [0])<128){
$word [0]=strtoupper($word [0]);}}
if($wordCase==1&&IsAnsiString($word)){
$word=strtoupper($word);}}}
function ShouldMakeDescriptionKeywordBold($pos,&$markedWordsIterator,&$keywordLocationList){
while($markedWordsIterator<count($keywordLocationList)){
$info=$keywordLocationList [$markedWordsIterator];
if($info==NULL || $info->position>$pos){
return FALSE;}
if($info->position==$pos){
return $info->bMarkBold;}
$markedWordsIterator++;}
return FALSE;}
function AddContentWordsToDescription(&$si,&$keywordLocationList,$pos,$count,&$markedWordsIterator,
&$charsLeft,&$buffer){
$bNonKeywordMode=FALSE;
if(SDBSeek($si->contentsDB,$pos)){
for($i=0;$i<$count;){
SDBGet($si->contentsDB,$record);
$keywordID=$record->data24;
$keywordBuffer='';
$bSpaceBefore=($record->data8&(0x1<<3))? FALSE : TRUE;
$wordCase=(($record->data8&0x6)>>1);
if(($record->data8&1)!=1){
$bNonKeywordMode=TRUE;}
if($charsLeft<=0){
break;}
if($bNonKeywordMode){
for($j=0;$j<3&&$charsLeft>1;$j++){
$str=chr(($record->data24&(0xFF<<(8*$j)))>>(8*$j));
if($j==0&&$bSpaceBefore){
$buffer .=' ';
$charsLeft--;}
if(ord($str)==0){
$bNonKeywordMode=FALSE;
break;}
if($str=='<'){
$buffer .='&lt;';
$charsLeft-=4;}
else if($str=='>'){
$buffer .='&gt;';
$charsLeft-=4;}
else{
$buffer .=$str;
$charsLeft--;}}}
else{
if($keywordID==0){
$bNonKeywordMode=TRUE;}
else{
if(SearchFindStringNameFromId($keywordID,$keywordBuffer,$si->keywordIndex2DB,$si->keywordDB,FALSE)){
$keywordLength=strlen($keywordBuffer);
FixWordCase($wordCase,$keywordBuffer);
$bMakeBold=ShouldMakeDescriptionKeywordBold($pos+$i,$markedWordsIterator,$keywordLocationList);
if($bSpaceBefore&&$charsLeft>1){
$buffer .=' ';
$charsLeft-=1;}
if($bMakeBold){
if($charsLeft>16){
$buffer .='<span class="b">';
$charsLeft-=16;}}
if($keywordLength<$charsLeft){
$buffer .=$keywordBuffer;
$charsLeft-=$keywordLength;}
else{
$charsLeft=0;
break;}
if($bMakeBold){
if($charsLeft>7){
$buffer .='</span>';
$charsLeft-=7;}}}}}
$i++;}
return TRUE;}
return FALSE;}
function CreateContentsDescription(&$si,$maxDescriptionLength,&$keywordLocationList,$startPos,$keywordCount,&$buffer){
global $contentPreviewBlockSize;
$lastPos=-1;
$charsLeft=MAXSTR-1;
$markedWordsIterator=0;
$updatedBlockSize=$contentPreviewBlockSize;
if(count($keywordLocationList)>0&&count($keywordLocationList)*$contentPreviewBlockSize<$maxDescriptionLength){
$updatedBlockSize=(int)($maxDescriptionLength/count($keywordLocationList));}
$lastCount=$updatedBlockSize;
for($i=0;$i<count($keywordLocationList);$i++){
$keywordInfo=&$keywordLocationList [$i];
if($keywordInfo->bDisplayed){
$pos=$keywordInfo->position-(int)($updatedBlockSize/2);
if($pos<$startPos){
$pos=$startPos;}
if($lastPos !=-1&&($pos-$lastPos<$lastCount)){
$pos=$lastPos+$lastCount;
$count=$keywordInfo->position+(int)($updatedBlockSize/2)+1-$pos;}
else{
$count=$updatedBlockSize;}
if($count>0){
if($pos+$count>$startPos+$keywordCount){
$count=$startPos+$keywordCount-$pos;}
if($lastPos==-1 ||($pos-$lastPos>$lastCount)){
$buffer .=' ...';
if(4<$charsLeft){
$charsLeft-=4;}}
AddContentWordsToDescription($si,$keywordLocationList,$pos,$count,
$markedWordsIterator,$charsLeft,$buffer);
$lastPos=$pos;
$lastCount=$count;}}}
return TRUE;}
function GetDescriptionFromContents(&$si,$URLID,&$buffer){
global $contentPreviewBlockCount;
global $contentPreviewBlockSize;
$retval=FALSE;
$bSearchRecord=SearchFindPosIn24_32IndexEx($indexPosInfo,$si->contentsIndexDB,$URLID,$dummy,0,$si->contentsIndexDB->size-1);
if($bSearchRecord){
if($indexPosInfo->endPos==-1){
$count=$si->contentsDB->size-$indexPosInfo->startPos;}
else{
$count=$indexPosInfo->endPos-$indexPosInfo->startPos;}
if(FindKeywordsInContents($si,$indexPosInfo->startPos,$count,$keywordLocationList)){
if(FilterKeywordsInContents($contentPreviewBlockCount*$contentPreviewBlockSize,$keywordLocationList)){
$buffer='';
CreateContentsDescription($si,$contentPreviewBlockCount*$contentPreviewBlockSize,$keywordLocationList,$indexPosInfo->startPos,$count,$buffer);
$retval=TRUE;}}}
return $retval;}
function GetURLStrings(&$si,$URLID,&$info){
global $sectionsCount;
$pos=0;
$length=0;
if(SearchFindPosInURLIndex($indexInfo,$si->URLIndexDB,$URLID)==FALSE){
return FALSE;}
SearchReadString($si->URLDB,$URL,$indexInfo->startPos);
$off=strlen($URL)+1;
for($i=0;$i<$sectionsCount;$i++){
SearchReadString($si->URLDB,$info->sections [$i],$indexInfo->startPos+$off);
$off+=strlen($info->sections [$i])+1;}
return TRUE;}
function GetSettingStringValue(&$hsdb,$off){
SearchReadString($hsdb,$val,$off);
return $val;}
function GetSettingByteValue(&$hsdb,$off){
SDBSeek($hsdb,$off);
SDBGet($hsdb,$byte);
return ord($byte);}
function GetSettingSpecialChars(&$hsdb,$off){
SDBSeek($hsdb,$off);
return fread($hsdb->file,CSPECIALCHARS*NEWSPECIALCHARSIZE);}
function GetSettingDoubleByteValue(&$hsdb,$off){
SDBSeek($hsdb,$off);
SDBGet($hsdb,$lowerByte);
SDBGet($hsdb,$higherByte);
return(ord($higherByte)<<8)| ord($lowerByte);}
function GetURLWithoutParams(&$URL,&$URLNoParams){
$newLength=-1;
$qmPos=strpos($URL,'?');
if($qmPos !==FALSE){
$newLength=$qmPos;}
$hashPos=strpos($URL,'#');
if($hashPos !==FALSE&&($newLength==-1 || $hashPos<$newLength)){
$newLength=$hashPos;}
if($newLength !=-1){
$URLNoParams=substr($URL,0,$newLength);}
else{
$URLNoParams=$URL;}}
function GetExtensionFromPath(&$path,&$extension){
$dot=strrpos($path,'.');
if($dot !==FALSE){
$slash=strrpos($path,'/');
if($slash===FALSE || $slash<$dot){
$extension=strtolower(substr($path,$dot+1));
return TRUE;}}
$extension='';
return FALSE;}
function GetExtensionFromURL(&$URL,&$extension,$bStripParams){
$URLNoParams='';
if($bStripParams){
GetURLWithoutParams($URL,$URLNoParams);
return GetExtensionFromPath($URLNoParams,$extension);}
else{
return GetExtensionFromPath($URL,$extension);}}
function SearchGetDocTypeFromURL(&$URL,$bStripParams){
$documentType=DOC_OTHER;
$documentExtension='';
if(GetExtensionFromURL($URL,$documentExtension,$bStripParams)){
if($documentExtension=='pdf'){
$documentType=DOC_PDF;}
else if($documentExtension=='doc' || $documentExtension=='rtf' ||
$documentExtension=='dot' || $documentExtension=='wpd' ||
$documentExtension=='ps' || $documentExtension=='odt' ||
$documentExtension=='chm'){
$documentType=DOC_DOC;}
else if($documentExtension=='xls' || $documentExtension=='ods'){
$documentType=DOC_XLS;}
else if($documentExtension=='ppt' || $documentExtension=='pps' ||
$documentExtension=='odp'){
$documentType=DOC_PPT;}
else if($documentExtension=='gz' || $documentExtension=='tar' ||
$documentExtension=='taz' || $documentExtension=='tgz' ||
$documentExtension=='z' || $documentExtension=='zip'){
$documentType=DOC_ARCHIVE;}
else if($documentExtension=='avi' || $documentExtension=='jpg' ||
$documentExtension=='mov' || $documentExtension=='mp3' ||
$documentExtension=='ogg' || $documentExtension=='png' ||
$documentExtension=='rm' || $documentExtension=='swf' ||
$documentExtension=='wma' || $documentExtension=='wmv' ||
$documentExtension=='ram'){
$documentType=DOC_MEDIA;}}
return $documentType;}
function IsDocumentRecent($year,$month,$day,$prevValidDayCount){
$firstValidTimeRaw=time()-60*60*24*$prevValidDayCount;
$filterTime=localtime($firstValidTimeRaw,TRUE);
if($year<1900+$filterTime ['tm_year']){
return FALSE;}
if($year==1900+$filterTime ['tm_year']){
if($month<$filterTime ['tm_mon']+1){
return FALSE;}
if($month==$filterTime ['tm_mon']+1){
if($day<$filterTime ['tm_mday']){
return FALSE;}}}
return TRUE;}
function ResultResolveConditionalCommands($docKind,&$resultTemplate,&$currentResult){
global $sectionsCount;
while(TRUE){
$tempInt=strpos($resultTemplate,'{{IF');
if($tempInt===FALSE){
break;}
$tempInt2=strpos($resultTemplate,'|',$tempInt);
if($tempInt2===FALSE){
break;}
$tempInt3=strpos($resultTemplate,'}}',$tempInt);
$tempInt4=strpos($resultTemplate,'{{IF',$tempInt+4);
if($tempInt4 !==FALSE&&$tempInt3 !==FALSE&&$tempInt4<$tempInt3){
$tempInt4=$tempInt3+2-$tempInt;
$tempInt3=strpos($resultTemplate,'}}',$tempInt+$tempInt4);}
if($tempInt3===FALSE || $tempInt3<=$tempInt2){
break;}
$tempInt+=6;
$bInclude=FALSE;
if($resultTemplate [$tempInt-2]=='D'){
$tempBool=($resultTemplate [$tempInt-1]=='-');
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=IsDocumentRecent($currentResult->dateYear,$currentResult->dateMonth,$currentResult->dateDay,
$tempInt4);
if($tempBool){
$bInclude=!$bInclude;}}
else if($resultTemplate [$tempInt-2]=='S'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
if(isset($currentResult->sections)&&isset($tempInt4)&&$tempInt4>=0&&$tempInt4<$sectionsCount){
$bInclude=strlen($currentResult->sections [$tempInt4])>0;}
else{
$bInclude=TRUE;}}
else{
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=(($tempInt4&$docKind)!=0);}
$includedCode='';
if($bInclude){
$includedCode=substr($resultTemplate,$tempInt2+1,$tempInt3-$tempInt2-1);}
$remainingCode=substr($resultTemplate,$tempInt3+2);
$resultTemplate=substr($resultTemplate,0,$tempInt-6). $includedCode . $remainingCode;}}
function GetMonthString($month){
$buf='';
switch($month){
case 1:
$buf='Jan';
break;
case 2:
$buf='Feb';
break;
case 3:
$buf='Mar';
break;
case 4:
$buf='Apr';
break;
case 5:
$buf='May';
break;
case 6:
$buf='Jun';
break;
case 7:
$buf='Jul';
break;
case 8:
$buf='Aug';
break;
case 9:
$buf='Sep';
break;
case 10:
$buf='Oct';
break;
case 11:
$buf='Nov';
break;
case 12:
$buf='Dec';
break;}
return $buf;}
function ResultReplaceDateString(&$resultTemplate,&$currentResult){
$tempInt=-1;
while(TRUE){
$tempInt3=$tempInt;
$tempInt=strpos($resultTemplate,'(docdate');
if($tempInt===FALSE || $tempInt<=$tempInt3){
break;}
$tempInt2=strpos($resultTemplate,')',$tempInt);
if($tempInt2===FALSE){
break;}
$tempInt+=8;
if($currentResult->dateYear>0){
$buf=substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$buf=str_replace('DD',$currentResult->dateDay,$buf);
$buf=str_replace('YYYY',$currentResult->dateYear,$buf);
$buf=str_replace('MMM',GetMonthString($currentResult->dateMonth),$buf);
$buf=str_replace('MM',$currentResult->dateMonth,$buf);}
else{
$buf='';}
$resultTemplate=str_replace(substr($resultTemplate,$tempInt-8,$tempInt2-$tempInt+8+1),$buf,$resultTemplate);}}
function ResultReplaceSizeString(&$resultTemplate,&$currentResult){
$sizeFr=(string)($currentResult->sizeFraction<10 ? $currentResult->sizeFraction : 0);
$size=(string)$currentResult->sizeMain;
if($currentResult->sizeFlags !=SIZE_FLAG_BYTES&&$currentResult->sizeFlags !=SIZE_FLAG_KBYTES){
$size .='.' . $sizeFr;}
if($currentResult->sizeFlags==SIZE_FLAG_KBYTES){
$size .='KB';}
if($currentResult->sizeFlags==SIZE_FLAG_MBYTES){
$size .='MB';}
if($currentResult->sizeFlags==SIZE_FLAG_GBYTES){
$size .='GB';}
$resultTemplate=str_replace('(docsize)',$size,$resultTemplate);}
function GetFilenameFromPath(&$path){
$lastChar=strrpos($path,'\\');
if($lastChar===FALSE){
$lastChar=strrpos($path,'/');}
if($lastChar !==FALSE){
return substr($path,$lastChar+1);}
else{
return $path;}}
function str_replace_no_case(&$src,&$trg,&$string,$bWholeWordOnly){
$pos=0;
$retstr='';
while(TRUE){
$newpos=strposi($string,$src,$pos,$bWholeWordOnly);
if($newpos===FALSE){
break;}
if($newpos-$pos>0)
$retstr .=substr($string,$pos,$newpos-$pos);
$retstr .=$trg;
$pos=$newpos+strlen($src);}
$retstr .=substr($string,$pos);
return $retstr;}
function MakeSearchKeywordsBold(&$si,&$string){
$currentExpression='';
for($i=0;$i<count($si->keywordList);$i++){
$keyword=&$si->keywordList [$i];
if($keyword->expressionPos>0){
if(!$keyword->bExpressionEnd){
$currentExpression .=$keyword->keyword . ' ';
$word='';}
else{
$word=$currentExpression . $keyword->keyword;
$currentExpression='';}}
else{
$word=$keyword->keyword;}
if(is_string($word)&&strlen($word)>0){
$n=strposi($string,$word,0,TRUE);
if($n !==FALSE){
$rep='<span class="b">' . substr($string,$n,strlen($word)). '</span>';
$string=@str_replace_no_case($word,$rep,$string,TRUE);}}}
return TRUE;}
function GetQueryWordList(&$si){
$str='';
for($i=0;$i<count($si->keywordList);$i++){
$keyword=&$si->keywordList [$i];
if(is_string($keyword->keyword)&&strlen($keyword->keyword)>0){
if($i>0)
$str .=' ';
$str .=$keyword->keyword;}}
return $str;}
function ResultReplaceSpecialStrings($currentResultNumber,$docKind,&$si,$contents,$targetFrame,&$resultTemplate,&$currentResult){
global $sectionsCount;
$docType='HTML';
$docName=GetFilenameFromPath($currentResult->URL);
if($docKind==DOC_PDF){
$docType='PDF';}
else if($docKind==DOC_DOC){
$docType='Text';}
else if($docKind==DOC_XLS){
$docType='Spreadsheet';}
else if($docKind==DOC_PPT){
$docType='Presentation';}
else if($docKind==DOC_ARCHIVE){
$docType='Archive';}
else if($docKind==DOC_MEDIA){
$docType='Media';}
if($docKind==DOC_PDF)
$curURL=$currentResult->URL . "#search=%22" . GetQueryWordList($si). "%22";
else
$curURL=$currentResult->URL;
for($i=0;$i<$sectionsCount;$i++){
$sectionStr=$currentResult->sections [$i];
MakeSearchKeywordsBold($si,$sectionStr);
$resultTemplate=str_replace("(section-$i)",$sectionStr,$resultTemplate);}
$resultTemplate=str_replace('(URLEx)',$curURL,$resultTemplate);
$resultTemplate=str_replace('(URL)',$currentResult->URL,$resultTemplate);
$resultTemplate=str_replace('(doctype)',$docType,$resultTemplate);
$resultTemplate=str_replace('(docname)',$docName,$resultTemplate);
$resultTemplate=str_replace('(resnumber)',$currentResultNumber,$resultTemplate);
$resultTemplate=str_replace('(trgframe)',$targetFrame,$resultTemplate);
$resultTemplate=str_replace('(doccontents)',is_string($contents)&&strlen($contents)>0 ? $contents : ' ',$resultTemplate);
$resultTemplate=str_replace('target=""','',$resultTemplate);
ResultReplaceDateString($resultTemplate,$currentResult);
ResultReplaceSizeString($resultTemplate,$currentResult);}
function ProcessResultCode(&$si,&$currentResult,$currentResultNumber,&$resultBuffer,
&$contents,&$targetFrame){
$docKind=$currentResult->docType;
ResultResolveConditionalCommands($docKind,$resultBuffer,$currentResult);
ResultReplaceSpecialStrings($currentResultNumber,$docKind,$si,$contents,$targetFrame,
$resultBuffer,$currentResult);}
function OverviewResolveConditionalCommands($currentPageNumber,$lastPageNumber,&$resultTemplate){
while(TRUE){
$tempInt=strpos($resultTemplate,'{{IF');
if($tempInt===FALSE){
break;}
$tempInt2=strpos($resultTemplate,'|',$tempInt);
if($tempInt2===FALSE){
break;}
$tempInt3=strpos($resultTemplate,'}}',$tempInt);
$tempInt4=strpos($resultTemplate,'{{IF',$tempInt+4);
if($tempInt4 !==FALSE&&$tempInt3 !==FALSE&&$tempInt4<$tempInt3){
$tempInt4=$tempInt3+2-$tempInt;
$tempInt3=strpos($resultTemplate,'}}',$tempInt+$tempInt4);}
if($tempInt3===FALSE || $tempInt3<=$tempInt2){
break;}
$tempInt+=6;
$bInclude=FALSE;
if($resultTemplate [$tempInt-2]=='N'&&$resultTemplate [$tempInt-1]=='L'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
if($tempInt4<0)
$tempInt4=0;
$bInclude=($currentPageNumber<$lastPageNumber-$tempInt4);}
else if($resultTemplate [$tempInt-2]=='G'&&$resultTemplate [$tempInt-1]=='T'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=($currentPageNumber>$tempInt4-1);}
else if($resultTemplate [$tempInt-2]=='L'&&$resultTemplate [$tempInt-1]=='A'){
$bInclude=($currentPageNumber==$lastPageNumber);}
else if($resultTemplate [$tempInt-2]=='E'&&$resultTemplate [$tempInt-1]=='X'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=($tempInt4-1<=$lastPageNumber);}
else if($resultTemplate [$tempInt-2]=='N'&&$resultTemplate [$tempInt-1]=='E'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=($tempInt4-1>$lastPageNumber);}
else if($resultTemplate [$tempInt-2]=='P'&&$resultTemplate [$tempInt-1]=='G'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=($currentPageNumber==$tempInt4-1);}
else if($resultTemplate [$tempInt-2]=='N'&&$resultTemplate [$tempInt-1]=='P'){
$tempInt4=(int)substr($resultTemplate,$tempInt,$tempInt2-$tempInt);
$bInclude=($currentPageNumber !=$tempInt4-1);}
$includedCode='';
if($bInclude){
$includedCode=substr($resultTemplate,$tempInt2+1,$tempInt3-$tempInt2-1);}
$remainingCode=substr($resultTemplate,$tempInt3+2);
$resultTemplate=substr($resultTemplate,0,$tempInt-6). $includedCode . $remainingCode;}}
function CreatePageLink($nPage,&$params){
$code='?';
$bFirst=TRUE;
$bstrtSet=FALSE;
$bwrapSet=FALSE;
$arr=&GetHttpParamArray();
if($arr){
reset($arr);
while(list($name,$value)=each($arr)){
if(strtolower($name)=="strt"){
$value=$nPage*$params->count;
$bstrtSet=TRUE;}
else if(strtolower($name)=="wrap"){
if($bwrapSet)
continue;
$bwrapSet=TRUE;
$code=$value . $code;}
if(strlen($value)>0){
if(!$bFirst)$code .="&";
$code .=$name . "=" . urlencode(stripslashes($value));
$bFirst=FALSE;}}}
if(!$bstrtSet){
if(!$bFirst)$code .="&";
$code .="strt=" .($nPage*$params->count);
$bFirst=FALSE;}
return $code;}
function OverviewReplaceSpecialStrings($maxResults,$currentPageNumber,$lastPage,$resultCount,
&$params,&$resultTemplate){
$lastResult=($currentPageNumber*$params->count)+$params->count;
if($lastResult>$resultCount){
$lastResult=$resultCount;}
if($resultCount<$maxResults){
$resultCountStr=$resultCount;}
else{
$resultCountStr='&gt;' . $maxResults;}
$resultTemplate=str_replace('(resultcount)',$resultCountStr,$resultTemplate);
$resultTemplate=str_replace('(firstresult)',($currentPageNumber*$params->count)+1,$resultTemplate);
$resultTemplate=str_replace('(lastresult)',$lastResult,$resultTemplate);
$resultTemplate=str_replace('(resultsperpage)',$params->count,$resultTemplate);
$resultTemplate=str_replace('(currentpage)',$currentPageNumber+1,$resultTemplate);
$resultTemplate=str_replace('(lastpage)',$lastPage+1,$resultTemplate);
$resultTemplate=str_replace('(searchquery)',$params->originalQueryString,$resultTemplate);
$resultTemplate=str_replace('(linkprev)',CreatePageLink($currentPageNumber-1,$params),$resultTemplate);
$resultTemplate=str_replace('(linknext)',CreatePageLink($currentPageNumber+1,$params),$resultTemplate);
for($nPage=0;$nPage<=$lastPage;$nPage++){
$resultTemplate=str_replace("(linkpage" .($nPage+1).")",CreatePageLink($nPage,$params),$resultTemplate);}
$prevSearchPos=-1;
while(true){
$searchPos=strpos($resultTemplate,"(nbpage");
if($searchPos==-1 || $searchPos<=$prevSearchPos)
break;
$prevSearchPos=$searchPos;
$endPos=strpos($resultTemplate,")",$searchPos+7);
if($endPos==-1)
break;
$offset=(int)substr($resultTemplate,$searchPos+9,$endPos-$searchPos-9);
$repString="";
if(substr($resultTemplate,$prevSearchPos+7,1)=='L'){
if(substr($resultTemplate,$prevSearchPos+8,1)=='P'){
$repString=CreatePageLink($currentPageNumber-$offset,$params);}
else{
$repString=CreatePageLink($currentPageNumber+$offset,$params);}}
else{
if(substr($resultTemplate,$prevSearchPos+8,1)=='P'){
$pageNumber=$currentPageNumber+1-$offset;
if($pageNumber<0)
$pageNumber=0;
$repString=$pageNumber;}
else{
$pageNumber=$currentPageNumber+1+$offset;
$repString=$pageNumber;}}
if(strlen($repString)>0){
$resultTemplate=str_replace(substr($resultTemplate,$searchPos,$endPos+1-$searchPos),$repString,$resultTemplate);}
else{
break;}}}
function ProcessOverviewCode($maxResults,$currentPageNumber,$resultCount,&$params,
&$resultBuffer){
$lastPage=(($resultCount % $params->count)!=0)?((int)($resultCount/$params->count)):(((int)($resultCount/$params->count))-1);
OverviewResolveConditionalCommands($currentPageNumber,$lastPage,$resultBuffer);
if($resultCount>0){
OverviewReplaceSpecialStrings($maxResults,$currentPageNumber,$lastPage,$resultCount,$params,$resultBuffer);}}
function PrintNormalResult(&$si,&$currentResult,$nResult,$firstResult){
global $string7;
global $resultFormatText;
$resultTemplate=$resultFormatText;
GetURLStrings($si,$currentResult->URLID,$currentResult);
$contents='';
if(strstr($resultTemplate,'(doccontents)')){
if(SDBIsInitialized($si->contentsDB)&&SDBIsInitialized($si->contentsIndexDB)&&
SDBIsInitialized($si->keywordIndex2DB)){
GetDescriptionFromContents($si,$currentResult->URLID,$contents);
$contents .='...';}}
ProcessResultCode($si,$currentResult,$nResult+$firstResult,$resultTemplate,$contents,$string7);
echo $resultTemplate;}
function PerformSearch(&$params){
global $string7;
global $resultFormatText;
global $contentPreviewBlockCount;
global $contentPreviewBlockSize;
global $resultOverviewText;
global $sectionsSize;
global $sectionsCount;
$si=new SearchInfo;
if(SearchInitialize($si,$params->prefixString)==FALSE){
echo "\n<br>Error: cannot open database files.<p>";
return;}
$si->bDemoVersion=GetSettingByteValue($si->settingsDB,BDEMO_OFF);
$maxResults=GetSettingDoubleByteValue($si->settingsDB,MAXRESULTS_OFF);
if($maxResults<CQUERYMINQUERYSIZE){
$maxResults=CQUERYMINQUERYSIZE;}
if($maxResults>CQUERYMAXQUERYSIZE){
$maxResults=CQUERYMAXQUERYSIZE;}
if($params->count>CQUERYMAXSCREENSIZE){
$params->count=CQUERYMAXSCREENSIZE;}
if($params->count==0){
$params->count=1;}
$cSkipResults=$params->first;
$string7=GetSettingStringValue($si->settingsDB,DEFAULTFRAME_OFF);
$resultFormatText=GetSettingStringValue($si->settingsDB,RESULTFORMATTEXT_OFF);
$contentPreviewBlockCount=GetSettingByteValue($si->settingsDB,CONTENTPREVIEWBLOCKCOUNT_OFF);
$contentPreviewBlockSize=GetSettingByteValue($si->settingsDB,CONTENTPREVIEWBLOCKSIZE_OFF);
$resultOverviewText=GetSettingStringValue($si->settingsDB,RESULTOVERVIEWTEXT_OFF);
$minWordLen=GetSettingByteValue($si->settingsDB,MINLEN_OFF);
$specialChars=GetSettingSpecialChars($si->settingsDB,SPECIALCHARACTERS_OFF);
$sectionsSize=GetSettingByteValue($si->settingsDB,SECTIONSSIZE_OFF);
$sectionsCount=GetSettingByteValue($si->settingsDB,SECTIONSCOUNT_OFF);
if($sectionsSize<=0 || $sectionsSize>4){
echo "Error reading sessearch.t. Make sure the file exists and has proper permissions";}
switch($params->sortType){
case SORT_URL:
$sortFunc="ResultSortByURLName";break;
case SORT_TYPE:
$sortFunc="ResultSortByType";break;
case SORT_SIZE:
$sortFunc="ResultSortBySize";break;
case SORT_DATE:
$sortFunc="ResultSortByDate";break;
default:
$sortFunc="ResultSortByScore";break;}
SearchStart($si,$params->queryString,$maxResults,$minWordLen,$specialChars,$params->searchFilter,$sortFunc,$params->codepage);
$totalResults=count($si->resultList);
if($params->first>=$totalResults){
$params->first=0;}
if($totalResults==0){
echo "\n<br>";
echo GetSettingStringValue($si->settingsDB,FONT1STR_OFF);
echo GetSettingStringValue($si->settingsDB,NORESULTSSTR_OFF);
echo GetSettingStringValue($si->settingsDB,FONT1ENDSTR_OFF);}
else{
ProcessOverviewCode($maxResults,(int)($params->first/$params->count),$totalResults,$params,
$resultOverviewText);
$markerPos=strpos($resultOverviewText,'(resultcode)');
if($markerPos !==FALSE){
echo substr($resultOverviewText,0,$markerPos);
$cCurrentResult=0;
for($i=0;$i<count($si->resultList)&&$cCurrentResult<$params->count;$i++){
$result=&$si->resultList [$i];
if($cSkipResults>0){
$cSkipResults=$cSkipResults-1;}
else{
PrintNormalResult($si,$result,$cCurrentResult+1,$params->first);
$cCurrentResult++;}}
echo substr($resultOverviewText,$markerPos+12);}}
if($params->first==0&&is_string($params->queryString)&&strlen($params->queryString)>0){
$logPath=GetSettingStringValue($si->settingsDB,LOG_OFF);
if(is_string($logPath)&&strlen($logPath)>0){
$file=@fopen($logPath,"a+b");
if($file){
$now=time();
$l=localtime($now,TRUE);
$line=sprintf("%02d.%02d.%04d\t%02d:%02d:%02d\t%d\t%s\n",$l['tm_mday'],$l['tm_mon']+1,$l['tm_year']+1900,$l['tm_hour'],$l['tm_min'],$l['tm_sec'],$totalResults,$params->queryString);
fwrite($file,$line);
fclose($file);}}}
SearchCleanup($si);}
function&GetHttpParamArray(){
global $_GET;
global $_POST;
global $NULL_VARS;
if(isset($_GET)&&count($_GET)>0)
return $_GET;
if(isset($_POST)&&count($_POST)>0)
return $_POST;
$NULL_VARS=NULL;
return $NULL_VARS;}
function GetHttpParam($name){
$arr=&GetHttpParamArray();
if($arr&&@$arr [$name])
return $arr [$name];
return NULL;}
function GetFcQuery(){
$fcFilter=GetHttpParam('fc');
if($fcFilter&&strlen($fcFilter)>0){
$str="{QF".$fcFilter."} ";
return $str;}}
function GetFilteredQuery($prefix){
$str='';
$ar=&GetHttpParamArray();
if($ar){
reset($ar);
while(list($key,$val)=each($ar)){
if(strncmp($key,$prefix,strlen($prefix))==0&&$val){
$str .=' {QF' . substr($key,strlen($prefix)). '} ' . $val;}}}
return $str;}
function CheckPhraseMode(&$query){
if(substr($query,0,1)=='"'&&substr($query,strlen($query)-1)=='"'){
$query=substr($query,1,strlen($query)-2);
return TRUE;}
return FALSE;}
$searchFilter=new SearchFilter;
$query=stripslashes(GetHttpParam('q'));
$op=GetHttpParam('op');
$searchFilter->bDefaultAnd=TRUE;
$searchFilter->bPhraseMode=CheckPhraseMode($query);
if($op=='or')
$searchFilter->bDefaultAnd=FALSE;
else if($op=='ph')
$searchFilter->bPhraseMode=TRUE;
if(!$query){
$query=GetHttpParam('qor');
if($query)
$searchFilter->bDefaultAnd=FALSE;
else{
$query=GetHttpParam('qph');
if($query)
$searchFilter->bPhraseMode=TRUE;}}
$params=new SearchParams;
$params->originalQueryString=$query;
if(!$query)
$query='';
else
$query=GetFcQuery().$query;
$codepage=CODEPAGE_UTF8;
$enc=GetHttpParam('enc');
if($enc){
if(strcasecmp($enc,'iso-8859-1')==0)
$codepage=CODEPAGE_ANSI;}
else{
$ae=GetHttpParam('ae');
if(ord($ae [0])==0xDF)
$codepage=CODEPAGE_ANSI;}
$query .=GetFilteredQuery('fq');
$query=stripslashes($query);
$start=GetHttpParam('strt');
if($start==NULL)
$start=0;
$cnt=GetHttpParam('cnt');
if($cnt==0)
$cnt=10;
$pref=GetHttpParam('pref');
if($pref==NULL)
$pref='';
else if(strpos($pref,'://')!==false)
$pref='';
$searchFilter->prevValidDayCount=(int)GetHttpParam('pvdc');
$searchFilter->validDocTypes=(int)GetHttpParam('vdt');
$searchFilter->URLGroup=GetHttpParam('sec');
if(GetHttpParam('df')=='on' || GetHttpParam('df')=='1'){
$searchFilter->startDateYear=GetHttpParam('sdy');
$searchFilter->startDateMonth=GetHttpParam('sdm');
$searchFilter->startDateDay=GetHttpParam('sdd');
$searchFilter->endDateYear=GetHttpParam('edy');
$searchFilter->endDateMonth=GetHttpParam('edm');
$searchFilter->endDateDay=GetHttpParam('edd');}
$params->queryString=$query;
$params->count=$cnt;
$params->first=$start;
$params->prefixString=$pref;
$params->sortType=GetHttpParam('sort');
$params->searchFilter=$searchFilter;
$params->scriptName="";
$params->codepage=$codepage;
$wrap=GetHttpParam('wrap');
if(!$wrap&&(!is_string($pref)|| !@include($pref . "header.htm")))
include("header.htm");
if($query)
PerformSearch($params);
if(!$wrap&&(!is_string($pref)|| !@include($pref . "footer.php")))
include("footer.php");
?>
