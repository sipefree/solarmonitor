/*
 Copyright (C) 2007-2009 Stig Brautaset. All rights reserved.
 
 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are met:
 
 * Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.
 
 * Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.
 
 * Neither the name of the author nor the names of its contributors may be used
   to endorse or promote products derived from this software without specific
   prior written permission.
 
 THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE
 FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

#import "NSString+SBJSON.h"
#import "SBJsonParser.h"

@implementation NSString (NSString_SBJSON)

- (id)JSONFragmentValue
{
    SBJsonParser *jsonParser = [SBJsonParser new];    
    id repr = [jsonParser fragmentWithString:self];    
    if (!repr)
        NSLog(@"-JSONFragmentValue failed. Error trace is: %@", [jsonParser errorTrace]);
    [jsonParser release];
    return repr;
}

- (id)JSONValue
{
    SBJsonParser *jsonParser = [SBJsonParser new];
    id repr = [jsonParser objectWithString:self];
    if (!repr)
        NSLog(@"-JSONValue failed. Error trace is: %@", [jsonParser errorTrace]);
    [jsonParser release];
    return repr;
}
/*void dumpString(NSString *str)
{
	NSUInteger len = [str length];
	unichar *chars = malloc(len * sizeof(unichar));
	[str getCharacters:chars];
	uint i;
	printf("NSString at %08p = { ", str);
	for( i = 0; i < len; i++ ) {
		if( i % 7 == 0 && i > 0 )
			printf("\n                        ");
		printf(" %c: 0x%04X ", chars[i], chars[i]);
	}
	printf(" }\n");
	free(chars);
}*/
- (NSString *) stringByEscapingUnicode  
{  
    NSMutableString *uniString = [ [ NSMutableString alloc ] init ];  
    UniChar *uniBuffer = (UniChar *) malloc ( sizeof(UniChar) * [ self length ] );  
    CFRange stringRange = CFRangeMake ( 0, [ self length ] );  
	
    CFStringGetCharacters ( (CFStringRef)self, stringRange, uniBuffer );  
	
    for ( int i = 0; i < [ self length ]; i++ ) {  
        if ( uniBuffer[i] > 0x7e )  
            [ uniString appendFormat: @"\\u%04x", uniBuffer[i] ];  
        else  
            [ uniString appendFormat: @"%c", uniBuffer[i] ];  
    }  
	
    free ( uniBuffer );  
	
    NSString *retString = [ NSString stringWithString: uniString ];  
    [ uniString release ];
	//NSLog(@"%@", retString);
	//dumpString(retString);
	
    return retString;  
}

- (NSComparisonResult) compareNumerically:(NSString *) other
{
	int myValue = [self intValue];
	int otherValue = [other intValue];
	if (myValue == otherValue) return NSOrderedSame;
	return (myValue < otherValue ? NSOrderedAscending : NSOrderedDescending);
}


@end
