//
//  SMImageDetailViewController.m
//
//  Created by Simon Free on 14/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMImageDetailViewController.h"

@implementation SMImageDetailViewController
@synthesize imageView, scrollView;

- (void)viewDidLoad {
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor viewFlipsideBackgroundColor];      
}

- (void)showImageWithData:(NSDictionary *)dict {
	// release the previously loaded image data
	[loadedImage release];
	
	// create space for the new image data
	loadedImage = [[NSMutableDictionary alloc] init];
	
	// show the activity indicator
	activity.hidden = NO;
	
	// remove the current image from the view
	self.imageView.image = nil;
	
	// set the tag to the type of the image
	imageTag = [dict objectForKey:@"type"];
	
	// release the previous image loader
	[loader release];
	
	// create the new image loader
	loader = [[SMImageLoader alloc] initWithDictionary:loadedImage delegate:self];
	
	// tell the loader to load the image based on the data we've given it
	[loader loadImagesFromKeysAndURLs:[NSDictionary dictionaryWithObjectsAndKeys:[NSURL URLWithString:[dict objectForKey:@"fullRes"]],imageTag,nil]];
	
	// get the timestamp
	NSString* time = [dict objectForKey:@"time"]; 
	
	// place the timestamp
	titleText.text = time;
}
- (IBAction)back:(id)sender {
	// return to the main view
    [self.delegate flipsideViewControllerDidFinish:self];
}

- (IBAction)save:(id)sender {
	// TODO: add a progress bar?
    UIImageWriteToSavedPhotosAlbum(self.imageView.image, nil, nil, nil);
}
- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	// there's only one image to load so this will be it
	
	// take the image
	UIImage* img = [loadedImage objectForKey:imageTag];
	
	// set the image view's image to the loaded image
	self.imageView.image = img;
	
	// get the ratio of the image's width to the screen's width
	float ratio = img.size.width/[[UIScreen mainScreen] bounds].size.width;
	
	// create a frame for the image to fit inside the screen
	CGRect imageFrame = CGRectMake(0,
								   ([[UIScreen mainScreen] bounds].size.height/2)-((img.size.height/ratio)/2),
								   [[UIScreen mainScreen] bounds].size.width, (img.size.height/ratio));
	
	// set the image view's frame to this frame
	self.imageView.frame = imageFrame;
	
	// set the scaling mode for this so it doesn't stretch
	self.imageView.contentMode = UIViewContentModeScaleAspectFit;
	
	// tell the image view how to resize itself inside the scroll view
	self.imageView.autoresizingMask = ( UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight);
	
	// configure the scaling mode of the scroll view to fit and not stretch
	scrollView.contentMode = (UIViewContentModeScaleAspectFit);
	
	// set the maximum zoom of the scroll view to be the full size of the image
	scrollView.maximumZoomScale = img.size.width / [[UIScreen mainScreen] bounds].size.width;
	
	// set the minimum zoom of the scroll view to a sane default
	scrollView.minimumZoomScale = 1;
	
	// tell the scroll view to only show objects that are inside its bounds
	scrollView.clipsToBounds = YES;
	
	// set the delegate of the scroll view
	scrollView.delegate = self;
	
	// hide the activity indicator
	activity.hidden = YES;
}

- (UIView *)viewForZoomingInScrollView:(UIScrollView *)scrollView {
	// boilerplate code
	return self.imageView;
}

- (void)imageLoaderDidComplete:(SMImageLoader *)sender {

}
- (void)dealloc {
	// cancel the image loader so it doesn't try to send a message to a released object
	// this will recursively cancel the url connection
	[loader cancel];
	
	// release ivars
	[loader release];
	[activity release];
	[loadedImage release];
	[super dealloc];
}
@end
