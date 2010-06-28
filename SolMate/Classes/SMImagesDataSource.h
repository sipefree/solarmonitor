//
//  SMImagesDataSource.h
//  SolMate
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "JSONDataSource.h"
#import "SMImageLoader.h"


@interface SMImagesDataSource : JSONDataSource <SMImageLoaderDelegate> {
	NSMutableDictionary* preloadedImages;
	SMImageLoader* loader;
}
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate;
- (NSArray *)thumbnails;
- (void)preloadImages;
@property (nonatomic, readonly) NSMutableDictionary* preloadedImages;
@end
